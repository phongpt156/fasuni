<?php

namespace App\Http\Controllers\Admin\SaleSoftware\KiotViet\Webhook;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\SaleSoftware\KiotViet\KiotVietController;
use App\Exceptions\HttpClient\RequestException;
use Illuminate\Database\QueryException;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Payment;
use App\Models\OrderPayment;

class OrderController extends WebhookController
{
    public function update(Request $request)
    {
        \Log::debug('updated order');

        $orders = $this->getRequestData($request);

        $kiotVietController = new KiotVietController($this->kiotVietService);

        foreach ($orders as $order) {
            $employeeId = null;
            if (!is_null($order['SoldById'])) {
                $employeeId = $kiotVietController->getEmployeeId($order['SoldById']);
            }

            $customerId = null;
            if (!is_null($order['CustomerId'])) {
                $customerId = $kiotVietController->getCustomerId($order['CustomerId']);
            }

            $branchId = null;
            if (!is_null($order['BranchId'])) {
                $branchId = $kiotVietController->getBranchId($order['BranchId']);
            }

            if (!is_null($order['Discount'])) {
                $discount = $order['Discount'];
            } else {
                $discount = 0;
            }

            try {
                $savedOrder = Order::updateOrCreate(
                    ['kiotviet_id' => $order['Id']],
                    ['code' => $order['Code'], 'total_price' => $order['Total'], 'discount_price' => $discount, 'source' => 'KiotViet', 'status_id' => $order['Status'], 'customer_id' => $customerId, 'employee_id' => $employeeId, 'branch_id' => $branchId]
                );
            } catch (QueryException $e) {
                \Log::error('Cannot save order: ' . $e->getMessage());
                response()->json(['error' => 'Cannot save order: ' . $e->getMessage()], 500)->send();
                die;
            }

            if (isset($order['OrderDetails'])) {
                $this->saveOrderDetails($order['OrderDetails'], $savedOrder->id, $kiotVietController);
            }

            if (isset($order['Payments'])) {
                $this->saveOrderPayments($order['Payments'], $savedOrder->id);
            }
        }
    }

    public function saveOrderDetails(Array $orderDetails = [], int $orderId, $kiotVietController)
    {
        $oldProductIds = OrderDetail::whereOrderId($orderId)->get()->pluck('product_id')->toArray();
        $newProductIds = [];

        foreach ($orderDetails as $orderDetail) {
            try {
                $productId = $kiotVietController->getProductId($orderDetail['ProductId']);
                array_push($newProductIds, $productId);

                try {
                    OrderDetail::updateOrCreate(
                        ['product_id' => $productId, 'order_id' => $orderId],
                        ['quantity' => $orderDetail['Quantity'], 'price' => $orderDetail['Price'], 'discount_price' => $orderDetail['Discount']]
                    );
                } catch (QueryException $e) {
                    \Log::error('Cannot save order detail: ' . $e->getMessage());
                    response()->json(['error' => 'Cannot save order detail: ' . $e->getMessage()], 500)->send();
                    die;
                }
            } catch (RequestException $e) {
                \Log::error('Không tìm thấy sản phẩm có mã sản phẩm là: ' . $orderDetail['ProductCode'] . ' hoặc sản phẩm đã bị xóa');
            }
        }

        $removeIds = array_diff($oldProductIds, $newProductIds);
        if (count($removeIds)) {
            try {
                OrderDetail::whereOrderId($orderId)->whereIn('product_id', $removeIds)->delete();
            } catch (QueryException $e) {
                \Log::error('Cannot delete order details: ' . $e->getMessage());
                response()->json(['error' => 'Cannot delete order details: ' . $e->getMessage()], 500)->send();
                die;
            }
        }
    }

    public function saveOrderPayments(Array $payments = [], int $orderId)
    {
        foreach ($payments as $kiotVietPayment) {
            $payment = Payment::whereMethod($kiotVietPayment->method)->first();

            try {
                OrderPayment::updateOrCreate(
                    ['kiotviet_id' => $kiotVietPayment['Id']],
                    ['amount' => $kiotVietPayment['Amount'], 'code' => $kiotVietPayment['Code'], 'order_id' => $orderId, 'payment_id' => $payment->id]
                );
            } catch (QueryException $e) {
                \Log::error('Cannot save order payment: ' . $e->getMessage());
                response()->json(['error' => 'Cannot save order payment: ' . $e->getMessage()], 500)->send();
                die;
            }
        }
    }
}
