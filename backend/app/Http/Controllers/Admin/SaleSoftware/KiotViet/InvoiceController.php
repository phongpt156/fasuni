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
use App\Models\Employee;

class InvoiceController extends Controller
{
    public static function saveInvoices(Array $invoices)
    {
        foreach ($invoices as $invoice) {
            $employeeId = null;
            if (isset($invoice->soldById)) {
                $employee = Employee::whereKiotvietId($invoice->soldById)->first();
                if ($employee) {
                    $employeeId = $employee->id;
                }
            }

            $customerId = null;
            if (isset($invoice->customerId)) {
                $customer = Customer::whereKiotvietId($invoice->customerId)->first();
                if ($customer) {
                    $customerId = $customer->id;
                }
            }

            $branchId = null;
            if (isset($invoice->branchId)) {
                $branch = Branch::whereKiotvietId($invoice->branchId)->first();
                if ($branch) {
                    $branchId = $branch->id;
                }
            }

            $orderId = null;
            if (isset($invoice->orderId)) {
                $order = Order::whereKiotvietId($invoice->orderId)->first();
                if ($order) {
                    $orderId = $order->id;
                }
            }

            if (isset($invoice->discount)) {
                $discount = $invoice->discount;
            } else {
                $discount = 0;
            }

            try {
                $savedInvoice = Invoice::updateOrCreate(
                    ['kiotviet_id' => $invoice->id],
                    ['code' => $invoice->code, 'total_price' => $invoice->total, 'discount_price' => $discount, 'source' => 'KiotViet', 'customer_id' => $customerId, 'employee_id' => $employeeId, 'branch_id' => $branchId, 'order_id' => $orderId]
                );
            } catch (QueryException $e) {
                \Log::error('Cannot save invoice: ' . $e->getMessage());
                throw $e;
            }

            if (isset($invoice->invoiceDetails)) {
                self::saveInvoiceDetails($invoice->invoiceDetails, $savedInvoice->id);
            }

            if (isset($invoice->payments)) {
                self::savePayments($invoice->payments, $savedInvoice->id);
            }
        }
    }

    public static function saveInvoiceDetails(Array $invoiceDetails = [], int $invoiceId)
    {
        foreach ($invoiceDetails as $invoiceDetail) {
            $product = Product::whereKiotvietId($invoiceDetail->productId)->first();

            if ($product) {
                if (isset($invoiceDetail->discount)) {
                    $discount = $invoice->discount;
                } else {
                    $discount = 0;
                }

                try {
                    InvoiceDetail::updateOrCreate(
                        ['product_id' => $product->id, 'invoice_id' => $invoiceId],
                        ['quantity' => $invoiceDetail->quantity, 'price' => $invoiceDetail->price, 'discount_price' => $discount]
                    );
                } catch (QueryException $e) {
                    \Log::error('Cannot save order detail: ' . $e->getMessage());
                    throw $e;
                }
            } else {
                \Log::error('Không tìm thấy sản phẩm có mã sản phẩm là: ' . $invoiceDetail->productCode . ' hoặc sản phẩm đã bị xóa');
            }
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
                \Log::error('Cannot save invoice payment: ' . $e->getMessage());
                throw $e;
            }
        }
    }
}
