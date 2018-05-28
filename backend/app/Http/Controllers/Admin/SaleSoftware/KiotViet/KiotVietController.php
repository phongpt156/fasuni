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
use App\Models\Category;
use App\Models\Branch;
use App\Models\Product;
use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\ProductAttributeValue;
use App\Models\ProductImage;
use App\Models\Inventory;
use App\Models\Customer;
use App\Models\Employee;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\OrderPayment;
use App\Models\Payment;
use App\Models\Invoice;
use App\Models\InvoiceDetail;
use App\Models\InvoicePayment;

class KiotVietController extends Controller
{
    private $kiotVietService;

    public function __construct(KiotVietService $kiotVietService)
    {
        $this->kiotVietService = $kiotVietService;
    }

    public function sync()
    {
        ini_set('max_execution_time', 0);

        $this->syncBranches();
        $this->syncCategories();
        $this->syncProducts();
        $this->syncCustomers();
        $this->syncEmployees();
        $this->syncOrders();
        $this->syncInvoices();

        return response()->json(['status' => 'Success'], 200);
    }

    public function syncLocations()
    {
        ini_set('max_execution_time', 0);

        try {
            $locations = $this->kiotVietService->getLocations()->Data;
        } catch (RequestException $e) {
            \Log::error('Cannot get locations: ' . $e->getMessage());
            $message = json_decode($e->getMessage());

            if (isset($message->ResponseStatus)) {
                return response()->json(['error' => 'Cannot get locations: ' . json_decode($e->getMessage())->ResponseStatus->Message], 500);
            }
            return response()->json(['error' => 'Cannot get locations: ' . $message->responseStatus->message], 500);
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
                \Log::error('Cannot save district: ' . $e->getMessage());
                die('Cannot save district: ' . $e->getMessage());
            }
        }

        try {
            $wards = $this->kiotVietService->getWards()->Data;
        } catch (RequestException $e) {
            \Log::error('Cannot get wards: ' . $e->getMessage());
            $message = json_decode($e->getMessage());

            if (isset($message->ResponseStatus)) {
                return response()->json(['error' => 'Cannot get wards: ' . json_decode($e->getMessage())->ResponseStatus->Message], 500);
            }
            return response()->json(['error' => 'Cannot get wards: ' . $message->responseStatus->message], 500);
        }

        foreach ($wards as $ward) {
            $district = District::whereKiotvietId($ward->ParentId)->first();

            try {
                Ward::updateOrCreate(
                    ['kiotviet_id' => $ward->Id],
                    ['name' => $ward->Name, 'district_id' => $district->id]
                );
            } catch (QueryException $e) {
                \Log::error('Cannot save ward: ' . $e->getMessage());
                return response()->json(['error' => 'Cannot save ward: ' . $e->getMessage()], 500);
                die('Cannot save ward: ' . $e->getMessage());
            }
        }

        return response()->json(['status' => 'success'], 200);
    }

    public function syncBranches()
    {
        $branches = $this->kiotVietService->branchService->getAll();
        $this->saveBranches($branches);
    }

    public function saveBranches(Array $branches = [])
    {
        foreach ($branches as $branch) {
            $this->saveBranch($branch);
        }
    }

    public function saveBranch(Object $branch)
    {
        try {
            Branch::updateOrCreate(
                ['kiotviet_id' => $branch->id],
                ['name' => $branch->branchName, 'phone_number' => optional($branch)->contactNumber, 'email' => optional($branch)->email, 'address' => optional($branch)->address]
            );
        } catch (QueryException $e) {
            \Log::error('Cannot save branch: ' . $e->getMessage());
            response()->json(['error' => 'Cannot save branches' . $e->getMessage()], 500)->send();
            die;
        }
    }

    public function getBranchId($kiotVietId)
    {
        $id = null;

        $branch = Branch::whereKiotvietId($kiotVietId)->first();
        if ($branch) {
            $id = $branch->id;
        } else {
            $branches = $this->kiotVietService->branchService->getAll();
            $this->saveBranches($branches);

            $branch = Branch::whereKiotvietId($kiotVietId)->first();
            $id = $branch->id;
        }

        return $id;
    }

    public function syncCategories()
    {
        $categories = $this->kiotVietService->categoryService->getAll();
        $this->saveHierarchyCategories($categories);
    }

    public function saveHierarchyCategories(Array $categories = [])
    {
        foreach ($categories as $category) {
            $this->saveCategory($category);
        }
    }

    public function saveCategory(Object $category)
    {
        $parentId = $this->getParentCategoryId($category);

        try {
            $savedCategory = Category::updateOrCreate(
                ['kiotviet_id' => $category->categoryId],
                ['name' => $category->categoryName, 'parent_id' => $parentId, 'slug' => str_slug($category->categoryName)]
            );
        } catch (QueryException $e) {
            \Log::error('Cannot save category: ' . $e->getMessage());
            response()->json(['error' => 'Cannot save categories' . $e->getMessage()], 500)->send();
            die;
        }

        if (isset($category->hasChild) && $category->hasChild) {
            $this->saveHierarchyCategories($category->children);
        }

        return $savedCategory;
    }

    public function getParentCategoryId(Object $category)
    {
        $parentId = null;

        if (isset($category->parentId)) {
            $parentId = $this->getCategoryId($category->parentId);
        }

        return $parentId;
    }

    public function getCategoryId($kiotVietId)
    {
        $category = Category::whereKiotvietId($kiotVietId)->first();

        if (!$category) {
            $category = $this->kiotVietService->categoryService->getOne($kiotVietId);
            $category = $this->saveCategory($category);
        }

        return $category->id;
    }

    public function syncProducts()
    {
        $products = $this->kiotVietService->productService->getAll();
        // reverse products to save from oldest to newest product because kiotviet not order product by date
        $this->saveProducts(array_reverse($products));
    }

    public function saveProducts(Array $products = [])
    {
        foreach ($products as $product) {
            $this->saveProduct($product);
        }
    }

    public function saveProduct(Object $product)
    {
        $categoryId = $this->getCategoryId($product->categoryId);
        $masterProductId = $this->getMasterProductId($product);

        try {
            $savedProduct = Product::updateOrCreate(
                ['kiotviet_id' => $product->id],
                ['name' => $product->name, 'sale_price' => $product->basePrice, 'weight' => optional($product)->weight, 'code' => $product->code, 'slug' => str_slug($product->name), 'category_id' => $categoryId, 'master_product_id' => $masterProductId, 'is_active' => $product->isActive]
            );
        } catch (QueryException $e) {
            \Log::error('Cannot save product: ' . $e->getMessage());
            response()->json(['error' => 'Cannot save product: ' . $e->getMessage()], 500)->send();
            die;
        }


        if (isset($product->attributes)) {
            $this->saveAttributes($product->attributes, $savedProduct->id);
        }

        if (isset($product->images)) {
            $this->saveImages($product->images, $savedProduct->id);
        }

        if (isset($product->inventories)) {
            $this->saveInventories($product->inventories, $savedProduct->id);
        }

        return $product;
    }

    public function getMasterProductId(Object $product)
    {
        $masterProductId = null;

        if (isset($product->masterProductId)) {
            $masterProductId = $this->getProductId($product->masterProductId);
        }

        return $masterProductId;
    }

    public function getProductId($kiotVietId)
    {
        $id = null;

        $product = Product::whereKiotvietId($kiotVietId)->first();

        if ($product) {
            $id = $product->id;
        } else {
            $product = $this->kiotVietService->productService->getOne($kiotVietId);
            $product = $this->saveProduct($product);
            $id = $product->id;
        }

        return $id;
    }

    public function saveImages(Array $images = [], int $productId)
    {
        foreach ($images as $image) {
            try {
                ProductImage::updateOrCreate(
                    ['original' => $image],
                    ['product_id' => $productId]
                );
            } catch (QueryException $e) {
                \Log::error('Cannot save product image: ' . $e->getMessage());
                response()->json(['error' => 'Cannot save product image: ' . $e->getMessage()], 500)->send();
                die;
            }
        }
    }

    public function saveAttributes(Array $attributes = [], int $productId)
    {
        foreach ($attributes as $kiotVietAttribute) {
            $attributeName = ucfirst(mb_strtolower($kiotVietAttribute->attributeName));
            try {
                $attribute = Attribute::updateOrCreate(
                    ['name' => $attributeName]
                );
            } catch (QueryException $e) {
                \Log::error('Cannot save attribute: ' . $e->getMessage());
                response()->json(['error' => 'Cannot save attribute: ' . $e->getMessage()], 500)->send();
                die;
            }

            try {
                $attributeValue = AttributeValue::updateOrCreate(
                    ['name' => $kiotVietAttribute->attributeValue],
                    ['attribute_id' => $attribute->id]
                );
            } catch (QueryException $e) {
                \Log::error('Cannot save attribute value: ' . $e->getMessage());
                response()->json(['error' => 'Cannot save attribute value: ' . $e->getMessage()], 500)->send();
                die;
            }

            try {
                ProductAttributeValue::updateOrCreate(
                    ['product_id' => $productId, 'attribute_value_id' => $attributeValue->id]
                );
            } catch (QueryException $e) {
                \Log::error('Cannot save product attribute value: ' . $e->getMessage());
                response()->json(['error' => 'Cannot save product attribute value: ' . $e->getMessage()], 500)->send();
                die;
            }
        }
    }

    public function saveInventories(Array $inventories = [], int $productId)
    {
        foreach ($inventories as $inventory) {
            $branchId = $this->getBranchId($inventory->branchId);

            try {
                Inventory::updateOrCreate(
                    ['product_id' => $productId, 'branch_id' => $branchId],
                    ['purchase_price' => $inventory->cost, 'quantity' => $inventory->onHand]
                );
            } catch (QueryException $e) {
                \Log::error('Cannot save inventory: ' . $e->getMessage());
                response()->json(['error' => 'Cannot save inventory: ' . $e->getMessage()], 500)->send();
                die;
            }
        }
    }

    public function syncCustomers()
    {
        $customers = $this->kiotVietService->customerService->getAll();
        $this->saveCustomers($customers);
    }

    public function saveCustomers(Array $customers = [])
    {
        foreach ($customers as $customer) {
            $this->saveCustomer($customer);
        }
    }

    public function saveCustomer(Object $customer)
    {
        $birthday = null;
        if (isset($customer->birthDate)) {
            $birthday = new \Datetime($customer->birthDate);
        }

        $cityId = null;
        $districtId = null;
        if (isset($customer->locationName)) {
            preg_match('/(.+) - (.+)/', $customer->locationName, $matches);
            $cityName = $matches[1];
            $districtName = $matches[2];

            $city = City::whereName($cityName)->first();
            if ($city) {
                $cityId = $city->id;
            }

            $district = District::whereName($districtName)->first();
            if ($district) {
                $districtId = $district->id;
            }
        }

        try {
            Customer::updateOrCreate(
                ['kiotviet_id' => $customer->id],
                ['name' => $customer->name, 'birthday' => $birthday, 'gender' => optional($customer)->gender, 'phone_number' => optional($customer)->contactNumber, 'address' => optional($customer)->address, 'email' => optional($customer)->email, 'code' => optional($customer)->code, 'living_city_id' => $cityId, 'district_id' => $districtId]
            );
        } catch (QueryException $e) {
            \Log::error('Cannot save customer: ' . $e->getMessage());
            response()->json(['error' => 'Cannot save customer: ' . $e->getMessage()], 500)->send();
            die;
        }
    }

    public function getCustomerId($kiotVietId)
    {
        $customer = Customer::whereKiotvietId($kiotVietId)->first();

        if (!$customer) {
            $customer = $this->kiotVietService->customerService->getOne($kiotVietId);
            $this->saveCustomer($customer);
        }

        return $customer->id;
    }

    public function syncEmployees()
    {
        $employees = $this->kiotVietService->employeeService->getAll();
        $this->saveEmployees($employees);
    }

    public function saveEmployees(Array $employees = [])
    {
        foreach ($employees as $employee) {
            $this->saveEmployee($employee);
        }
    }

    public function saveEmployee(Object $employee)
    {
        $birthday = null;
        if (isset($employee->birthDate)) {
            $birthday = new \DateTime($employee->birthDate);
        }

        try {
            Employee::updateOrCreate(
                ['kiotviet_id' => $employee->id],
                ['username' => $employee->userName, 'name' => $employee->givenName, 'address' => optional($employee)->adddress, 'phone_number' => optional($employee)->mobilePhone, 'email' => optional($employee)->email, 'birthday' => $birthday]
            );
        } catch (QueryException $e) {
            \Log::error('Cannot save employee: ' . $e->getMessage());
            response()->json(['error' => 'Cannot save employee: ' . $e->getMessage()], 500)->send();
            die;
        }
    }

    public function getEmployeeId($kiotVietId)
    {
        $id = null;

        $employee = Employee::whereKiotvietId($kiotVietId)->first();

        if ($employee) {
            $id = $employee->id;
        } else {
            $employees = $this->kiotVietService->employeeService->getAll();
            $this->saveEmployees($employees);

            $employee = Employee::whereKiotvietId($kiotVietId)->first();
            if ($employee) {
                $id = $employee->id;
            }
        }

        return $id;
    }

    public function syncOrders()
    {
        $orders = $this->kiotVietService->orderService->getAll();
        $this->saveOrders($orders);
    }

    public function saveOrders(Array $orders = [])
    {
        foreach ($orders as $order) {
            $this->saveOrder($order);
        }
    }

    public function saveOrder(Object $order)
    {
        $employeeId = null;
        if (isset($order->soldById)) {
            $employeeId = $this->getEmployeeId($order->soldById);
        }

        $customerId = null;
        if (isset($order->customerId)) {
            $customerId = $this->getCustomerId($order->customerId);
        }

        $branchId = null;
        if (isset($order->branchId)) {
            $branchId = $this->getBranchId($order->branchId);
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
            \Log::error('Cannot save order: ' . $e->getMessage());
            response()->json(['error' => 'Cannot save order: ' . $e->getMessage()], 500)->send();
            die;
        }

        if (isset($order->orderDetails)) {
            $this->saveOrderDetails($order->orderDetails, $savedOrder->id);
        }

        if (isset($order->payments)) {
            $this->saveOrderPayments($order->payments, $savedOrder->id);
        }
    }

    public function saveOrderDetails(Array $orderDetails = [], int $orderId)
    {
        foreach ($orderDetails as $orderDetail) {
            try {
                $productId = $this->getProductId($orderDetail->productId);

                try {
                    OrderDetail::updateOrCreate(
                        ['product_id' => $productId, 'order_id' => $orderId],
                        ['quantity' => $orderDetail->quantity, 'price' => $orderDetail->price, 'discount_price' => $orderDetail->discount]
                    );
                } catch (QueryException $e) {
                    \Log::error('Cannot save order detail: ' . $e->getMessage());
                    response()->json(['error' => 'Cannot save order detail: ' . $e->getMessage()], 500)->send();
                    die;
                }
            } catch (RequestException $e) {
                \Log::error('Không tìm thấy sản phẩm có mã sản phẩm là: ' . $orderDetail->productCode . ' hoặc sản phẩm đã bị xóa');
            }
        }
    }

    public function saveOrderPayments(Array $payments = [], int $orderId)
    {
        foreach ($payments as $kiotVietPayment) {
            $payment = Payment::whereMethod($kiotVietPayment->method)->first();

            try {
                OrderPayment::updateOrCreate(
                    ['kiotviet_id' => $kiotVietPayment->id],
                    ['amount' => $kiotVietPayment->amount, 'code' => $kiotVietPayment->code, 'order_id' => $orderId, 'payment_id' => $payment->id]
                );
            } catch (QueryException $e) {
                \Log::error('Cannot save order payment: ' . $e->getMessage());
                response()->json(['error' => 'Cannot save order payment: ' . $e->getMessage()], 500)->send();
                die;
            }
        }
    }

    public function syncInvoices()
    {
        $invoices = $this->kiotVietService->invoiceService->getAll();
        $this->saveInvoices($invoices);
    }

    public function saveInvoices(Array $invoices = [])
    {
        foreach ($invoices as $invoice) {
            $this->saveInvoice($invoice);
        }
    }

    public function saveInvoice(Object $invoice)
    {
        $employeeId = null;
        if (isset($invoice->soldById)) {
            $employeeId = $this->getEmployeeId($invoice->soldById);
        }

        $customerId = null;
        if (isset($invoice->customerId)) {
            $customerId = $this->getCustomerId($invoice->customerId);
        }

        $branchId = null;
        if (isset($invoice->branchId)) {
            $branchId = $this->getBranchId($invoice->branchId);
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
                ['code' => $invoice->code, 'total_price' => $invoice->total, 'discount_price' => $discount, 'customer_id' => $customerId, 'employee_id' => $employeeId, 'branch_id' => $branchId, 'order_id' => $orderId]
            );
        } catch (QueryException $e) {
            \Log::error('Cannot save invoice: ' . $e->getMessage());
            throw $e;
        }

        if (isset($invoice->invoiceDetails)) {
            $this->saveInvoiceDetails($invoice->invoiceDetails, $savedInvoice->id);
        }

        if (isset($invoice->payments)) {
            $this->saveInvoicePayments($invoice->payments, $savedInvoice->id);
        }
    }

    public function saveInvoiceDetails(Array $invoiceDetails = [], int $invoiceId)
    {
        foreach ($invoiceDetails as $invoiceDetail) {
            try {
                $productId = $this->getProductId($invoiceDetail->productId);

                try {
                    InvoiceDetail::updateOrCreate(
                        ['product_id' => $productId, 'invoice_id' => $invoiceId],
                        ['quantity' => $invoiceDetail->quantity, 'price' => $invoiceDetail->price, 'discount_price' => $invoiceDetail->discount]
                    );
                } catch (QueryException $e) {
                    \Log::error('Cannot save invoice detail: ' . $e->getMessage());
                    response()->json(['error' => 'Cannot save invoice detail: ' . $e->getMessage()], 500)->send();
                    die;
                }
            } catch (RequestException $e) {
                \Log::error('Không tìm thấy sản phẩm có mã sản phẩm là: ' . $invoiceDetail->productCode . ' hoặc sản phẩm đã bị xóa');
            }
        }
    }

    public function saveInvoicePayments(Array $payments = [], int $invoiceId)
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
