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
        $kiotVietService = new KiotVietService;

        $branches = $kiotVietService->branchService->getAll();
        try {
            BranchController::saveBranches($branches);
        } catch (QueryException $e) {
            die('Cannot save branches: ' . $e->getMessage());
        }

        $categories = $kiotVietService->categoryService->getAll();
        try {
            CategoryController::saveHierarchyCategories($categories);
        } catch (QueryException $e) {
            die('Cannot save categories: ' . $e->getMessage());
        }

        $products = $kiotVietService->productService->getAll();
        try {
            // reverse products to save from oldest to newest product
            ProductController::saveProducts(array_reverse($products));
        } catch (QueryException $e) {
            die('Cannot save products: ' . $e->getMessage());
        }

        $customers = $kiotVietService->customerService->getAll();
        try {
            CustomerController::saveCustomers($customers);
        } catch (QueryException $e) {
            die('Cannot save customers: ' . $e->getMessage());
        }

        $employees = $kiotVietService->employeeService->getAll();
        try {
            EmployeeController::saveEmployees($employees);
        } catch (QueryException $e) {
            die('Cannot save employees: ' . $e->getMessage());
        }

        $orders = $kiotVietService->orderService->getAll();
        // \Log::debug($orders);
        try {
            OrderController::saveOrders($orders);
        } catch (QueryException $e) {
            die('Cannot save orders: ' . $e->getMessage());
        }
    }
}
