<?php

namespace App\Http\Controllers\Admin\SaleSoftware\KiotViet;

use Illuminate\Database\QueryException;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\ProductAttributeValue;
use App\Models\ProductImage;
use App\Models\Branch;
use App\Models\Inventory;
use App\Http\Services\KiotViet\KiotVietService;

class ProductController extends Controller
{
    private $kiotVietService;

    public function __construct(KiotVietService $kiotVietService)
    {
        $this->kiotVietService = $kiotVietService;
    }

    public function saveProducts(Array $kiotVietProducts = [])
    {
        foreach ($kiotVietProducts as $kiotVietProduct) {
            $this->saveProduct($kiotVietProduct);
        }
    }

    public function saveProduct(Object $kiotVietProduct)
    {
        $categoryId = $this->getCategoryId($kiotVietProduct->categoryId);
        $masterProductId = $this->getMasterProductId($kiotVietProduct);

        try {
            $product = Product::updateOrCreate(
                ['kiotviet_id' => $kiotVietProduct->id],
                ['name' => $kiotVietProduct->name, 'sale_price' => $kiotVietProduct->basePrice, 'weight' => optional($kiotVietProduct)->weight, 'code' => $kiotVietProduct->code, 'slug' => str_slug($kiotVietProduct->name), 'category_id' => $categoryId, 'master_product_id' => $masterProductId, 'is_active' => $kiotVietProduct->isActive]
            );
        } catch (QueryException $e) {
            \Log::error('Cannot save product: ' . $e->getMessage());
            throw $e;
        }


        if (isset($kiotVietProduct->attributes)) {
            $this->saveAttributes($kiotVietProduct->attributes, $product->id);
        }

        if (isset($kiotVietProduct->images)) {
            $this->saveImages($kiotVietProduct->images, $product->id);
        }

        if (isset($kiotVietProduct->inventories)) {
            $this->saveInventories($kiotVietProduct->inventories, $product->id);
        }

        return $product;
    }

    public function getCategoryId(int $kiotVietId)
    {
        $category = Category::whereKiotvietId($kiotVietId)->first();

        if (!$category) {
            $category = $this->kiotVietService->categoryService->getOne($kiotVietId);
            $categoryController = new CategoryController($this->kiotVietService);
            $category = $categoryController->saveCategory($category);
        }

        return $category->id;
    }

    public function getMasterProductId(Object $product)
    {
        $id = null;

        if (isset($product->masterProductId)) {
            $masterProduct = Product::whereKiotvietId($product->masterProductId)->first();

            if (!$masterProduct) {
                $masterProduct = $this->kiotVietService->productService->getOne($product->masterProductId);
                $masterProduct = self::saveProduct($masterProduct);
            }
            $id = $masterProduct->id;
        }

        return $id;
    }

    public function saveImages(Array $images, int $productId)
    {
        foreach ($images as $image) {
            try {
                ProductImage::updateOrCreate(
                    ['original' => $image],
                    ['product_id' => $productId]
                );
            } catch (QueryException $e) {
                \Log::error('Cannot save product image: ' . $e->getMessage());
                throw $e;
            }
        }
    }

    public function saveAttributes(Array $attributes, int $productId)
    {
        foreach ($attributes as $kiotVietAttribute) {
            $attributeName = ucfirst(mb_strtolower($kiotVietAttribute->attributeName));
            try {
                $attribute = Attribute::updateOrCreate(
                    ['name' => $attributeName]
                );
            } catch (QueryException $e) {
                \Log::error('Cannot save attribute: ' . $e->getMessage());
                throw $e;
            }

            try {
                $attributeValue = AttributeValue::updateOrCreate(
                    ['name' => $kiotVietAttribute->attributeValue],
                    ['attribute_id' => $attribute->id]
                );
            } catch (QueryException $e) {
                \Log::error('Cannot save attribute value: ' . $e->getMessage());
                throw $e;
            }

            try {
                ProductAttributeValue::updateOrCreate(
                    ['product_id' => $productId, 'attribute_value_id' => $attributeValue->id]
                );
            } catch (QueryException $e) {
                \Log::error('Cannot save product attribute value: ' . $e->getMessage());
                throw $e;
            }
        }
    }

    public function saveInventories(Array $inventories, int $productId)
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
                throw $e;
            }
        }
    }

    public function getBranchId($kiotVietId)
    {
        $id = null;

        $branch = Branch::whereKiotvietId($kiotVietId)->first();
        if ($branch) {
            $id = $branch->id;
        } else {
            try {
                $branches = $this->kiotVietService->branchService->getAll();
                BranchController::saveBranches($branches);
            } catch (RequestException $e) {
                \Log::error('Cannot get branches: ' . $e->getMessage());
                throw $e;
            }

            $branch = Branch::whereKiotvietId($kiotVietId)->first();
            $id = $branch->id;
        }

        return $id;
    }
}
