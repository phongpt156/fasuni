<?php

namespace App\Http\Controllers\Admin\SaleSoftware\KiotViet;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Exceptions\HttpClient\RequestException;
use Illuminate\Database\QueryException;
use App\Http\Services\KiotViet\KiotVietService;

class KiotVietController extends Controller
{
    public function sync()
    {
        ini_set('max_execution_time', 0);

        $kiotVietService = new KiotVietService;
        $response = [];

        try {
            $branches = $kiotVietService->branchService->getAll();
            BranchController::saveBranches($branches);
        } catch (RequestException $e) {
            \Log::debug('Cannot get branches: ' . $e->getMessage());
            return response()->json(['error' => 'Cannot get branches: ' . json_decode($e->getMessage())->ResponseStatus->Message], 500);
        } catch (QueryException $e) {
            return response()->json(['error' => 'Cannot save branches' . $e->getMessage()], 200);
        }

        try {
            $categories = $kiotVietService->categoryService->getAll();
            CategoryController::saveHierarchyCategories($categories);
        } catch (RequestException $e) {
            \Log::debug('Cannot get categories: ' . $e->getMessage());
            return response()->json(['error' => 'Cannot get categories: ' . json_decode($e->getMessage())->ResponseStatus->Message], 500);
        } catch (QueryException $e) {
            return response()->json(['error' => 'Cannot save categories' . $e->getMessage()], 200);
        }

        try {
            $products = $kiotVietService->productService->getAll();
            // reverse products to save from oldest to newest product because kiotviet not order product by date
            ProductController::saveProducts(array_reverse($products));
        } catch (RequestException $e) {
            \Log::debug('Cannot get products: ' . $e->getMessage());
            return response()->json(['error' => 'Cannot get products: ' . json_decode($e->getMessage())->ResponseStatus->Message], 500);
        } catch (QueryException $e) {
            return response()->json(['error' => 'Cannot save products' . $e->getMessage()], 200);
        }

        try {
            $customers = $kiotVietService->customerService->getAll();
            CustomerController::saveCustomers($customers);
        } catch (RequestException $e) {
            \Log::debug('Cannot get customers: ' . $e->getMessage());
            return response()->json(['error' => 'Cannot get customers: ' . json_decode($e->getMessage())->ResponseStatus->Message], 500);
        } catch (QueryException $e) {
            return response()->json(['error' => 'Cannot save customers' . $e->getMessage()], 200);
        }

        try {
            $employees = $kiotVietService->employeeService->getAll();
            EmployeeController::saveEmployees($employees);
        } catch (RequestException $e) {
            \Log::debug('Cannot get employees: ' . $e->getMessage());
            return response()->json(['error' => 'Cannot get employees: ' . json_decode($e->getMessage())->ResponseStatus->Message], 500);
        } catch (QueryException $e) {
            return response()->json(['error' => 'Cannot save employees' . $e->getMessage()], 200);
        }

        try {
            $orders = $kiotVietService->orderService->getAll();
            OrderController::saveOrders($orders);
        } catch (RequestException $e) {
            \Log::debug('Cannot get orders: ' . $e->getMessage());
            return response()->json(['error' => 'Cannot get orders: ' . json_decode($e->getMessage())->ResponseStatus->Message], 500);
        } catch (QueryException $e) {
            return response()->json(['error' => 'Cannot save orders' . $e->getMessage()], 200);
        }

        try {
            $invoices = $kiotVietService->invoiceService->getAll();
            InvoiceController::saveInvoices($invoices);
        } catch (RequestException $e) {
            \Log::debug('Cannot get invoices: ' . $e->getMessage());
            return response()->json(['error' => 'Cannot get invoices: ' . json_decode($e->getMessage())->ResponseStatus->Message], 500);
        } catch (QueryException $e) {
            return response()->json(['error' => 'Cannot save invoices' . $e->getMessage()], 200);
        }

        return response()->json(['status' => 'Success'], 200);
    }

    public function registerWebhook()
    {
        $kiotVietService = new KiotVietService;
        try {
            $kiotVietService->webhookService->register();
        } catch (RequestException $e) {
            \Log::debug('Cannot register webhook: ' . $e->getMessage());
        }
    }
}
