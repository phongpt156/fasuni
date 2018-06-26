<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;
use App\Http\Controllers\Controller;
use App\Http\Services\KiotViet\KiotVietService;
use App\Models\User;
use App\Models\Customer;
use App\Models\Product;
use App\Models\District;
use App\Models\Ward;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Employee;
use App\Models\Branch;
use App\Models\DeliveryDetail;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $auth = new Auth;

        $user = $auth::guard()->user();

        if ($user) {
            $kiotVietService = new KiotVietService;

            $orderDetails = [];
            $request->products = collect($request->products);
            $products = Product::whereIn('id', $request->products->pluck('id'))->get();

            if (count($products) > 0) {
                foreach ($products as $product) {
                    foreach ($request->products as $productRequest) {
                        if ($productRequest['id'] === $product->id) {
                            array_push($orderDetails, [
                                'productId' => $product->kiotviet_id,
                                'quantity' => $productRequest['quantity'],
                                'price' => $productRequest['sale_price']
                            ]);

                            break;
                        }
                    }
                }
                $kiotVietDistrictId = District::whereId($request->receiver_district_id)->first()->kiotviet_id;

                if ($user->name) {
                    $customerName = $user->name;
                } else if($user->facebook_name) {
                    $customerName = $user->facebook_name;
                } else if($user->google_name) {
                    $customerName = $user->facebook_name;
                } else {
                    $customerName = $user->first_name . ' ' . $user->last_name;
                }

                $branch = Branch::whereName('Chi nhánh trung tâm')->first();
                $employee = Employee::whereName('Website Fasuni')->first();

                $payload = [
                    'purchaseDate' => new \DateTime,
                    'branchId' => $branch->kiotviet_id,
                    'soldById' => $employee->kiotviet_id,
                    'orderDetails' => $orderDetails,
                    'orderDelivery' => [
                        'type' => 0,
                        'receiver' => $request->receiver_name,
                        'contactNumber' => $request->receiver_phone,
                        'address' => $request->receiver_address,
                        'locationId' => $kiotVietDistrictId,
                    ],
                    'customer' => [
                        'name' => $customerName,
                        'contactNumber' => $request->receiver_phone
                    ],
                    'description' => $request->note
                ];

                $response = $kiotVietService->orderService->create($payload);

                try {
                    $customer = Customer::updateOrCreate(
                        ['kiotviet_id' => $response->customerId],
                        ['name' => $response->customerName, 'user_id' => $user->id]
                    );
                } catch (QueryException $e) {
                    \Log::error($e->getFile() . ' ' . $e->getLine() . ' error: Cannot save customer: ' . $e->getMessage());
                    return response()->json(['error' => 'Cannot save customer'], 500);
                }

                try {
                    $order = Order::updateOrCreate(
                        ['kiotviet_id' => $response->id],
                        ['code' => $response->code, 'total_price' => $request->total_price,'source' => 'Website', 'status_id' => 1, 'customer_id' => $customer->id, 'employee_id' => $employee->id, 'branch_id' => $branch->id]
                    );
                } catch (QueryException $e) {
                    \Log::error($e->getFile() . ' ' . $e->getLine() . ' error: Cannot save order: ' . $e->getMessage());
                    return response()->json(['error' => 'Cannot save order'], 500);
                }

                $productDetails = [];
                foreach ($request->products as $product) {
                    array_push($productDetails, [
                        'product_id' => $product['id'],
                        'order_id' => $order->id,
                        'quantity' => $product['quantity'],
                        'price' => $product['sale_price']
                    ]);
                }
                try {
                    OrderDetail::insert($productDetails);
                } catch (QueryException $e) {
                    \Log::error($e->getFile() . ' ' . $e->getLine() . ' error: Cannot save order details: ' . $e->getMessage());
                }

                try {
                    DeliveryDetail::updateOrCreate(
                        ['order_id' => $order->id],
                        ['receiver_name' => $request->receiver_name, 'receiver_phone' => $request->receiver_phone, 'receiver_address' => $request->receiver_address, 'note' => $request->note, 'receiver_district_id' => $request->receiver_district_id, 'receiver_ward_id' => $request->receiver_ward_id ?? null]
                    );
                } catch (QueryException $e) {
                    \Log::error($e->getFile() . ' ' . $e->getLine() . ' error: Cannot save delivery detail: ' . $e->getMessage());
                }

                return response()->json($order, 200);
            }
            return response()->json(['error' => 'Không có sản phẩm trong đơn hàng'], 500);
        }

        return response()->json(null, 401);
    }

    public function show($code)
    {
        $auth = new Auth;

        $user = $auth::guard()->user();

        if ($user) {
            $customer = Customer::whereUserId($user->id)->first();

            if ($customer) {
                $order = Order::whereCode($code)->with('deliveryDetail.district.city', 'deliveryDetail.ward', 'orderDetails.product.images', 'orderDetails.product.masterProduct.subProducts.images', 'orderDetails.product.masterProduct.images', 'orderDetails.product.subProducts.images')->first();

                return response()->json($order, 200);
            }

            return response()->json(['error' => 'You dont have permission to view this order'], 401);
        }

        return response()->json(['error' => 'You dont have permission to view this order'], 401);
    }

    public function getOrderHistoriesOfUser()
    {
        $auth = new Auth;

        $user = $auth::guard()->user();
        
        if ($user) {
            $customer = Customer::whereUserId($user->id)->first();

            if ($customer) {
                $orders = Order::whereCustomerId($customer->id)->whereSource('Website')->with('orderDetails.product')->get();

                return response()->json($orders, 200);
            }
            return response()->json([], 200);
        }

        return response()->json([], 200);
    }

    public function destroy($id)
    {
        $auth = new Auth;

        $user = $auth::guard()->user();
        
        if ($user) {
            $customer = Customer::whereUserId($user->id)->first();

            if ($customer) {
                $order = Order::whereCustomerId($customer->id)->whereId($id)->with('orderDetails.product')->first();

                if ($order) {
                    $kiotVietService = new KiotVietService;
                    $kiotVietService->orderService->delete($order->kiotviet_id);

                    $order->status_id = 4;
                    try {
                        $order->save();

                        return response()->json($order, 200);
                    } catch (QueryException $e) {
                        \Log::error($e->getFile() . ' ' . $e->getLine() . ' error: Cannot delete order: ' . $e->getMessage());
                        return response()->json(null, 500);
                    }
                }

                return response()->json(['error' => 'You dont have permission'], 401);
            }

            return response()->json(['error' => 'You dont have permission'], 401);
        }

        return response()->json(['error' => 'You dont have permission'], 401);
    }
}
