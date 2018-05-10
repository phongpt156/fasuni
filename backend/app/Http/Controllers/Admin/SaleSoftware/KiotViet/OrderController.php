<?php

namespace App\Http\Controllers\Admin\SaleSoftware\KiotViet;

use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;
use App\Models\Order;
use App\Models\Employee;
use App\Models\Customer;
use App\Models\OrderDetail;
use App\Models\OrderPayment;
use App\Models\Product;
use App\Models\Branch;
use App\Models\Payment;

class OrderController extends Controller
{
    public static function saveOrders(Array $orders = [])
    {
        foreach ($orders as $order) {
            $employee = Employee::whereKiotvietId($order->soldById)->first();
            if ($employee) {
                $employeeId = $employee->id;
            } else {
                $employeeId = null;
            }

            $customerId = null;
            if (isset($order->customerId)) {
                $customer = Customer::whereKiotvietId($order->customerId)->first();
                if ($customer) {
                    $customerId = $customer->id;
                }
            }

            $branchId = null;
            if (isset($order->branchId)) {
                $branch = Branch::whereKiotvietId($order->branchId)->first();
                if ($branch) {
                    $branchId = $branch->id;
                }
            }
            

            try {
                $savedOrder = Order::updateOrCreate(
                    ['kiotviet_id' => $order->id],
                    ['code' => $order->code, 'total_price' => $order->total, 'discount_price' => optional($order)->discount, 'status_id' => $order->status, 'customer_id' => $customerId, 'employee_id' => $employeeId, 'branch_id' => $branchId]
                );
            } catch (QueryException $e) {
                \Log::debug('Cannot save order: ' . $e->getMessage());
                throw $e;
            }

            if (isset($order->orderDetails)) {
                self::saveOrderDetails($order->orderDetails, $savedOrder->id);
            }

            if (isset($order->payments)) {
                self::saveOrderPayments($order->payments, $savedOrder->id);
            }
        }
    }

    public static function saveOrderDetails(Array $orderDetails = [], int $orderId)
    {
        foreach ($orderDetails as $orderDetail) {
            $product = Product::whereKiotvietId($orderDetail->productId)->first();

            if ($product) {
                try {
                    $orderDetailModel = OrderDetail::whereProductId($product->id)->whereOrderId($orderId)->update(
                        ['quantity' => $orderDetail->quantity, 'price' => $orderDetail->price, 'discount_price' => $orderDetail->discount]
                    );
                } catch (QueryException $e) {
                    \Log::debug('Cannot save order detail: ' . $e->getMessage());
                    throw $e;
                }

                if (!$orderDetailModel) {
                    $orderDetailModel = new OrderDetail;
                    $orderDetailModel->quantity = $orderDetail->quantity;
                    $orderDetailModel->price = $orderDetail->price;
                    $orderDetailModel->discount_price = $orderDetail->discount;

                    try {
                        $orderDetailModel->save();
                    } catch (QueryException $e) {
                        \Log::debug('Cannot save order detail: ' . $e->getMessage());
                        throw $e;
                    }
                }
            } else {
                \Log::debug('Không tìm thấy sản phẩm có mã sản phẩm là: ' . $product->productCode);
            }
        }
    }

    public static function saveOrderPayments(Array $orderPayments = [], int $orderId)
    {
        foreach ($orderPayments as $orderPayment) {
            $payment = Payment::whereMethod($orderPayment->method)->first();
            try {
                OrderPayment::updateOrCreate(
                    ['kiotviet_id' => $payment->id],
                    ['amount' => $orderPayment->amount, 'order_id' => $orderId, 'payment_id' => $payment->id]
                );
            } catch (QueryException $e) {
                \Log::debug('Cannot save order payment: ' . $e->getMessage());
                throw $e;
            }
        }
    }
}
