<?php

namespace App\Http\Controllers\Admin\SaleSoftware\KiotViet\Webhook;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\SaleSoftware\KiotViet\KiotVietController;
use App\Exceptions\HttpClient\RequestException;
use Illuminate\Database\QueryException;
use App\Models\Invoice;
use App\Models\InvoiceDetail;
use App\Models\Payment;
use App\Models\InvoicePayment;

class InvoiceController extends WebhookController
{
    public function update(Request $request)
    {
        \Log::debug('updated invoice');

        $invoices = $this->getRequestData($request);

        $kiotVietController = new KiotVietController($this->kiotVietService);

        foreach ($invoices as $invoice) {
            $employeeId = null;
            if (!is_null($invoice['SoldById'])) {
                $employeeId = $kiotVietController->getEmployeeId($invoice['SoldById']);
            }

            $customerId = null;
            if (!is_null($invoice['CustomerId'])) {
                $customerId = $kiotVietController->getCustomerId($invoice['CustomerId']);
            }

            $branchId = null;
            if (!is_null($invoice['BranchId'])) {
                $branchId = $kiotVietController->getBranchId($invoice['BranchId']);
            }

            $orderId = null;
            if (isset($invoice['OrderId'])) {
                $order = Order::whereKiotvietId($invoice['OrderId'])->first();
                if ($order) {
                    $orderId = $order->id;
                }
            }

            if (isset($invoice['Discount'])) {
                $discount = $invoice['Discount'];
            } else {
                $discount = 0;
            }

            try {
                $savedInvoice = Invoice::updateOrCreate(
                    ['kiotviet_id' => $invoice['Id']],
                    ['code' => $invoice['Code'], 'total_price' => $invoice['Total'], 'discount_price' => $discount, 'customer_id' => $customerId, 'employee_id' => $employeeId, 'branch_id' => $branchId, 'order_id' => $orderId]
                );
            } catch (QueryException $e) {
                \Log::error('Cannot save invoice: ' . $e->getMessage());
                throw $e;
            }

            if (!is_null($invoice['InvoiceDetails'])) {
                $this->saveInvoiceDetails($invoice['InvoiceDetails'], $savedInvoice->id, $kiotVietController);
            }

            if (isset($invoice['Payments'])) {
                $this->saveInvoicePayments($invoice['Payments'], $savedInvoice->id);
            }
        }
    }

    public function saveInvoiceDetails(Array $invoiceDetails = [], int $invoiceId, $kiotVietController)
    {
        $oldProductIds = InvoiceDetail::whereInvoiceId($orderId)->get()->pluck('product_id')->toArray();
        $newProductIds = [];

        foreach ($invoiceDetails as $invoiceDetail) {
            try {
                $productId = $kiotVietController->getProductId($invoiceDetail['ProductId']);
                array_push($newProductIds, $productId);

                try {
                    InvoiceDetail::updateOrCreate(
                        ['product_id' => $productId, 'invoice_id' => $invoiceId],
                        ['quantity' => $invoiceDetail['Quantity'], 'price' => $invoiceDetail['Price'], 'discount_price' => $invoiceDetail['Discount']]
                    );
                } catch (QueryException $e) {
                    \Log::error('Cannot save invoice detail: ' . $e->getMessage());
                    response()->json(['error' => 'Cannot save invoice detail: ' . $e->getMessage()], 500)->send();
                    die;
                }
            } catch (RequestException $e) {
                \Log::error('Không tìm thấy sản phẩm có mã sản phẩm là: ' . $invoiceDetail['ProductCode'] . ' hoặc sản phẩm đã bị xóa');
            }
        }

        $removeIds = array_diff($oldProductIds, $newProductIds);
        if (count($removeIds)) {
            try {
                InvoiceDetail::whereInvoiceId($orderId)->whereIn('product_id', $removeIds)->delete();
            } catch (QueryException $e) {
                \Log::error('Cannot delete invoice details: ' . $e->getMessage());
                response()->json(['error' => 'Cannot delete invoice details: ' . $e->getMessage()], 500)->send();
                die;
            }
        }
    }

    public function saveInvoicePayments(Array $payments = [], int $invoiceId)
    {
        foreach ($payments as $kiotVietPayment) {
            $payment = Payment::whereMethod($kiotVietPayment['Method'])->first();

            try {
                InvoicePayment::updateOrCreate(
                    ['kiotviet_id' => $kiotVietPayment['Id']],
                    ['amount' => $kiotVietPayment['Amount'], 'code' => $kiotVietPayment['Code'], 'invoice_id' => $invoiceId, 'payment_id' => $payment->id]
                );
            } catch (QueryException $e) {
                \Log::error('Cannot save invoice payment: ' . $e->getMessage());
                throw $e;
            }
        }
    }
}
