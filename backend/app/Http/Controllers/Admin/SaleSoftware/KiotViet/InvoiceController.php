<?php

namespace App\Http\Controllers\Admin\SaleSoftware\KiotViet;

use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\InvoicePayment;
use App\Models\Payment;
use App\Models\Customer;
use App\Models\Branch;
use App\Models\OrderDetail;
use App\Models\Product;

class InvoiceController extends Controller
{
    public static function saveInvoices(Array $invoices)
    {
        \Log::debug($invoices);
        foreach ($invoices as $invoice) {
            $customerId = null;
            if (isset($invoice->customerId)) {
                $customer = Customer::whereKiotvietId($invoice->customerId)->first();
                if ($customer) {
                    $customerId = $customer->id;
                }
            }

            $employeeId = null;
            if (isset($invoice->soldById)) {
                $employee = Customer::whereKiotvietId($invoice->soldById)->first();
                if ($employee) {
                    $employeeId = $employee->id;
                }
            }

            $branchId = null;
            if (isset($invoice->branchId)) {
                $branch = Branch::whereKiotvietId($invoice->branchId)->first();
                if ($branch) {
                    $branchId = $branch->id;
                }
            }

            if (!isset($invoice->orderId)) {
                $orderKiotvietId = $invoice->id;
            } else {
                $orderKiotvietId = $invoice->orderId;
            }

            $discountPrice = 0;
            if (isset($invoice->discount)) {
                $discountPrice = $invoice->discount;
            }

            $order = Order::whereKiotvietId($orderKiotvietId)->first();
            if (!$order) {
                $order = new Order;
                $order->code = $invoice->code;
                $order->kiotviet_id = $orderKiotvietId;
            }
            $order->total_price = $invoice->total;
            $order->discount_price = $discountPrice;
            $order->source = 'KiotViet';
            $order->status_id = 3;
            $order->customer_id = $customerId;
            $order->employee_id = $employeeId;
            $order->branch_id = $branchId;

            try {
                $order->save();
            } catch (QueryException $e) {
                \Log::debug('Cannot save order: ' . $e->getMessage());
                throw $e;
            }

            if (isset($invoice->invoiceDetails)) {
                self::saveOrderDetails($invoice->invoiceDetails, $order->id);
            }

            $savedInvoice = self::saveInvoice($invoice, $order->id);

            if (isset($invoice->payments)) {
                self::savePayments($invoice->payments, $savedInvoice->id);
            }
        }
    }

    public static function saveOrderDetails(Array $orderDetails = [], int $orderId)
    {
        foreach ($orderDetails as $orderDetail) {
            $product = Product::whereKiotvietId($orderDetail->productId)->first();

            if ($product) {
                $discount = 0;

                if (isset($orderDetail->discount)) {
                    $discount = $orderDetail->discount;
                }
                try {
                    OrderDetail::updateOrCreate(
                        ['product_id' => $product->id, 'order_id' => $orderId],
                        ['quantity' => $orderDetail->quantity, 'price' => $orderDetail->price, 'discount_price' => $discount]
                    );
                } catch (QueryException $e) {
                    \Log::debug('Cannot save order detail: ' . $e->getMessage());
                    throw $e;
                }
            } else {
                \Log::debug('Không tìm thấy sản phẩm có mã sản phẩm là: ' . $product->productCode);
            }
        }
    }

    public static function saveInvoice($invoice, $orderId)
    {
        try {
            $invoice = Invoice::updateOrCreate(
                ['order_id' => $orderId],
                ['code' => $invoice->code, 'kiotviet_id' => $invoice->id]
            );

            return $invoice;
        } catch (QueryException $e) {
            \Log::debug('Cannot save invoice: ' . $e->getMessage());
            throw $e;
        }
    }

    public static function savePayments(Array $payments = [], int $invoiceId)
    {
        foreach ($payments as $kiotVietPayment) {
            $payment = Payment::whereMethod($kiotVietPayment->method)->first();

            try {
                InvoicePayment::updateOrCreate(
                    ['kiotviet_id' => $kiotVietPayment->id],
                    ['amount' => $kiotVietPayment->amount, 'code' => $kiotVietPayment->code, 'invoice_id' => $invoiceId, 'payment_id' => $payment->id]
                );
            } catch (QueryException $e) {
                \Log::debug('Cannot save order payment: ' . $e->getMessage());
                throw $e;
            }
        }
    }
}
