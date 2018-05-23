<?php

namespace App\Http\Controllers\Admin\SaleSoftware\KiotViet;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Exceptions\HttpClient\RequestException;
use Illuminate\Database\QueryException;
use App\Http\Services\KiotViet\KiotVietService;
use App\Models\District;
use App\Models\Ward;
use App\Models\City;

class KiotVietController extends Controller
{
    public function sync()
    {
        ini_set('max_execution_time', 0);

        $kiotVietService = new KiotVietService;
        $response = [];

        $locations = $kiotVietService->getLocations();
        // \Log::debug($locations);
        die;

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
            $categoryController = new CategoryController($kiotVietService);
            $categoryController->saveHierarchyCategories($categories);
        } catch (RequestException $e) {
            \Log::debug('Cannot get categories: ' . $e->getMessage());
            return response()->json(['error' => 'Cannot get categories: ' . json_decode($e->getMessage())->ResponseStatus->Message], 500);
        } catch (QueryException $e) {
            return response()->json(['error' => 'Cannot save categories' . $e->getMessage()], 500);
        }

        try {
            $products = $kiotVietService->productService->getAll();
            $productController = new ProductController($kiotVietService);
            // reverse products to save from oldest to newest product because kiotviet not order product by date
            $productController->saveProducts(array_reverse($products));
        } catch (RequestException $e) {
            \Log::debug('Cannot get products: ' . $e->getMessage());
            return response()->json(['error' => 'Cannot get products: ' . json_decode($e->getMessage())->ResponseStatus->Message], 500);
        } catch (QueryException $e) {
            return response()->json(['error' => 'Cannot save products' . $e->getMessage()], 500);
        }

        try {
            $customers = $kiotVietService->customerService->getAll();
            CustomerController::saveCustomers($customers);
        } catch (RequestException $e) {
            \Log::debug('Cannot get customers: ' . $e->getMessage());
            return response()->json(['error' => 'Cannot get customers: ' . json_decode($e->getMessage())->ResponseStatus->Message], 500);
        } catch (QueryException $e) {
            return response()->json(['error' => 'Cannot save customers' . $e->getMessage()], 500);
        }

        try {
            $employees = $kiotVietService->employeeService->getAll();
            EmployeeController::saveEmployees($employees);
        } catch (RequestException $e) {
            \Log::debug('Cannot get employees: ' . $e->getMessage());
            return response()->json(['error' => 'Cannot get employees: ' . json_decode($e->getMessage())->ResponseStatus->Message], 500);
        } catch (QueryException $e) {
            return response()->json(['error' => 'Cannot save employees' . $e->getMessage()], 500);
        }

        // try {
        //     $orders = $kiotVietService->orderService->getAll();
        //     OrderController::saveOrders($orders);
        // } catch (RequestException $e) {
        //     \Log::debug('Cannot get orders: ' . $e->getMessage());
        //     return response()->json(['error' => 'Cannot get orders: ' . json_decode($e->getMessage())->ResponseStatus->Message], 500);
        // } catch (QueryException $e) {
        //     return response()->json(['error' => 'Cannot save orders' . $e->getMessage()], 500);
        // }

        // try {
        //     $invoices = $kiotVietService->invoiceService->getAll();
        //     InvoiceController::saveInvoices($invoices);
        // } catch (RequestException $e) {
        //     \Log::debug('Cannot get invoices: ' . $e->getMessage());
        //     return response()->json(['error' => 'Cannot get invoices: ' . json_decode($e->getMessage())->ResponseStatus->Message], 500);
        // } catch (QueryException $e) {
        //     return response()->json(['error' => 'Cannot save invoices' . $e->getMessage()], 500);
        // }

        return response()->json(['status' => 'Success'], 200);
    }

    public function registerWebhook()
    {
        $kiotVietService = new KiotVietService;
        try {
            $kiotVietService->webhookService->register();
        } catch (RequestException $e) {
            \Log::debug('Cannot register webhook: ' . $e->getMessage());
            return response()->json(['error' => 'Cannot register webhook: ' . json_decode($e->getMessage())->responseStatus->message], 500);
        }
    }

    public function syncLocations()
    {
        ini_set('max_execution_time', 0);

        $kiotVietService = new KiotVietService;
        try {
            $locations = $kiotVietService->getLocations()->Data;
        } catch (RequestException $e) {
            \Log::debug('Cannot get locations: ' . $e->getMessage());
            return response()->json(['error' => 'Cannot get locations: ' . json_decode($e->getMessage())->responseStatus->message], 500);
        }

        foreach ($locations as $location) {
            preg_match('/(.+) - (.+)/', $location->Name, $matches);
            $cityName = $matches[1];
            $districtName = $matches[2];

            $city = City::whereName($cityName)->first();

            try {
                District::updateOrCreate(
                    ['kiotviet_id' => $location->Id],
                    ['name' => $districtName, 'city_id' => $city->id]
                );
            } catch (QueryException $e) {
                \Log::debug('Cannot save district: ' . $e->getMessage());
                die('Cannot save district: ' . $e->getMessage());
            }
        }

        try {
            $wards = $kiotVietService->getWards()->Data;
        } catch (RequestException $e) {
            \Log::debug('Cannot get wards: ' . $e->getMessage());
            return response()->json(['error' => 'Cannot get wards: ' . json_decode($e->getMessage())->responseStatus->message], 500);
        }

        foreach ($wards as $ward) {
            $district = District::whereKiotvietId($ward->ParentId)->first();

            try {
                Ward::updateOrCreate(
                    ['kiotviet_id' => $ward->Id],
                    ['name' => $ward->Name, 'district_id' => $district->id]
                );
            } catch (QueryException $e) {
                \Log::debug('Cannot save ward: ' . $e->getMessage());
                die('Cannot save ward: ' . $e->getMessage());
            }
        }

        return response()->json(['status' => 'success'], 200);
    }
}
