<?php

namespace App\Http\Controllers\Admin\SaleSoftware\KiotViet;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use App\Http\Services\KiotViet\KiotVietService;

class KiotVietController extends Controller
{
    public function sync()
    {
        ini_set('max_execution_time', 0);

        $kiotVietService = new KiotVietService;

        $branches = $kiotVietService->branchService->getAll();
        try {
            BranchController::saveBranches($branches);
        } catch (QueryException $e) {
            return response()->json(['error' => 'Cannot save branches' . $e->getMessage()], 500);
        }

        $categories = $kiotVietService->categoryService->getAll();
        try {
            CategoryController::saveHierarchyCategories($categories);
        } catch (QueryException $e) {
            return response()->json(['error' => 'Cannot save categories' . $e->getMessage()], 500);
        }

        $products = $kiotVietService->productService->getAll();
        try {
            // reverse products to save from oldest to newest product because kiotviet not order product by date
            ProductController::saveProducts(array_reverse($products));
        } catch (QueryException $e) {
            return response()->json(['error' => 'Cannot save products' . $e->getMessage()], 500);
        }

        $customers = $kiotVietService->customerService->getAll();
        try {
            CustomerController::saveCustomers($customers);
        } catch (QueryException $e) {
            return response()->json(['error' => 'Cannot save customers' . $e->getMessage()], 500);
        }

        $employees = $kiotVietService->employeeService->getAll();
        try {
            EmployeeController::saveEmployees($employees);
        } catch (QueryException $e) {
            return response()->json(['error' => 'Cannot save employees' . $e->getMessage()], 500);
        }

        $orders = $kiotVietService->orderService->getAll();
        try {
            OrderController::saveOrders($orders);
        } catch (QueryException $e) {
            return response()->json(['error' => 'Cannot save orders' . $e->getMessage()], 500);
        }

        $invoices = $kiotVietService->invoiceService->getAll();
        try {
            InvoiceController::saveInvoices($invoices);
        } catch (QueryException $e) {
            return response()->json(['error' => 'Cannot save invoices' . $e->getMessage()], 500);
        }

        return response()->json(['status' => 'Success'], 200);
    }
}
