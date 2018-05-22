<?php

namespace App\Http\Controllers\Admin\SaleSoftware\KiotViet;

use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;
use App\Models\Order;
use App\Models\Employee;
use App\Models\Customer;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\Branch;
use App\Models\Payment;
use App\Models\Invoice;
use App\Models\OrderPayment;

class OrderController extends Controller
{
    public static function saveOrders(Array $orders = [])
    {
        foreach ($orders as $order) {
            $employeeId = null;
            if (isset($order->soldById)) {
                $employee = Employee::whereKiotvietId($order->soldById)->first();
                if ($employee) {
                    $employeeId = $employee->id;
                }
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

            if (isset($order->discount)) {
                $discount = $order->discount;
            } else {
                $discount = 0;
            }
            

            try {
                $savedOrder = Order::updateOrCreate(
                    ['kiotviet_id' => $order->id],
                    ['code' => $order->code, 'total_price' => $order->total, 'discount_price' => $discount, 'source' => 'KiotViet', 'status_id' => $order->status, 'customer_id' => $customerId, 'employee_id' => $employeeId, 'branch_id' => $branchId]
                );
            } catch (QueryException $e) {
                \Log::debug('Cannot save order: ' . $e->getMessage());
                throw $e;
            }

            if (isset($order->orderDetails)) {
                self::saveOrderDetails($order->orderDetails, $savedOrder->id);
            }

            if (isset($order->payments)) {
                self::savePayments($order->payments, $savedOrder->id);
            }
        }
    }

    public static function saveOrderDetails(Array $orderDetails = [], int $orderId)
    {
        foreach ($orderDetails as $orderDetail) {
            $product = Product::whereKiotvietId($orderDetail->productId)->first();

            if ($product) {
                try {
                    OrderDetail::updateOrCreate(
                        ['product_id' => $product->id, 'order_id' => $orderId],
                        ['quantity' => $orderDetail->quantity, 'price' => $orderDetail->price, 'discount_price' => $orderDetail->discount]
                    );
                } catch (QueryException $e) {
                    \Log::debug('Cannot save order detail: ' . $e->getMessage());
                    throw $e;
                }
            } else {
                \Log::debug('Không tìm thấy sản phẩm có mã sản phẩm là: ' . $orderDetail->productCode . ' hoặc sản phẩm đã bị xóa');
            }
        }
    }

    public static function savePayments(Array $payments = [], int $orderId)
    {
        foreach ($payments as $kiotVietPayment) {
            $payment = Payment::whereMethod($kiotVietPayment->method)->first();

            try {
                OrderPayment::updateOrCreate(
                    ['kiotviet_id' => $kiotVietPayment->id],
                    ['amount' => $kiotVietPayment->amount, 'code' => $kiotVietPayment->code, 'order_id' => $orderId, 'payment_id' => $payment->id]
                );
            } catch (QueryException $e) {
                \Log::debug('Cannot save order payment: ' . $e->getMessage());
                throw $e;
            }
        }
    }
}
