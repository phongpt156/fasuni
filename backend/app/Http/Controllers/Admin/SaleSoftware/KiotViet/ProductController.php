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

class ProductController extends Controller
{
    public static function saveProducts(Array $products = [])
    {
        foreach ($products as $kiotVietProduct) {
            $product = Product::whereKiotvietId($kiotVietProduct->id)->first();
            if (!$product) {
                $product = new Product;
            }

            $category = Category::whereKiotvietId($kiotVietProduct->categoryId)->first();
            if ($category) {
                $product->category_id = $category->id;
            }

            if (isset($kiotVietProduct->masterProductId)) {
                $masterProduct = Product::whereKiotvietId($kiotVietProduct->masterProductId)->first();

                if ($masterProduct) {
                    $product->master_product_id = $masterProduct->id;
                }
            }

            $product->name = $kiotVietProduct->name;
            $product->base_price = $kiotVietProduct->basePrice;
            $product->code = $kiotVietProduct->code;
            $product->kiotviet_id = $kiotVietProduct->id;
            $product->is_active = $kiotVietProduct->isActive;
            $product->quantity =  $kiotVietProduct->inventories[0];

            try {
                $product = Product::updateOrCreate(
                    ['kiotviet_id' => $product->kiotviet_id],
                    ['name' => $product->name, 'base_price' => $product->base_price, 'weight' => optional($product)->weight, 'code' => $product->code, 'category_id' => $product->category_id, 'master_product_id' => $product->master_product_id, 'is_active' => $product->is_active]
                );
            } catch (QueryException $e) {
                \Log::debug('Cannot save product: ' . $e->getMessage());
                throw $e;
            }


            if (isset($kiotVietProduct->attributes)) {
                self::saveAttributes($kiotVietProduct->attributes, $product->id);
            }

            if (isset($kiotVietProduct->images)) {
                self::saveImages($kiotVietProduct->images, $product->id);
            }

            if (isset($kiotVietProduct->inventories)) {
                self::saveInventories($kiotVietProduct->inventories, $product->id);
            }
        }
    }

    public static function saveImages(Array $images, int $productId)
    {
        foreach ($images as $image) {
            try {
                ProductImage::updateOrCreate(
                    ['original' => $image],
                    ['product_id' => $productId]
                );
            } catch (QueryException $e) {
                \Log::debug('Cannot save product image: ' . $e->getMessage());
                throw $e;
            }
        }
    }

    public static function saveAttributes(Array $attributes, int $productId)
    {
        foreach ($attributes as $kiotVietAttribute) {
            $attributeName = ucfirst(mb_strtolower($kiotVietAttribute->attributeName));
            try {
                $attribute = Attribute::updateOrCreate(
                    ['name' => $attributeName]
                );
            } catch (QueryException $e) {
                \Log::debug('Cannot save attribute: ' . $e->getMessage());
                throw $e;
            }

            try {
                $attributeValue = AttributeValue::updateOrCreate(
                    ['name' => $kiotVietAttribute->attributeValue],
                    ['attribute_id' => $attribute->id]
                );
            } catch (QueryException $e) {
                \Log::debug('Cannot save attribute value: ' . $e->getMessage());
                throw $e;
            }

            try {
                ProductAttributeValue::updateOrCreate(
                    ['product_id' => $productId, 'attribute_value_id' => $attributeValue->id]
                );
            } catch (QueryException $e) {
                \Log::debug('Cannot save product attribute value: ' . $e->getMessage());
                throw $e;
            }
        }
    }

    public static function saveInventories(Array $inventories, int $productId)
    {
        foreach ($inventories as $inventory) {
            $branchId = null;
            $branch = Branch::whereKiotvietId($inventory->branchId)->first();
            if ($branch) {
                $branchId = $branch->id;
            } else {
                \Log::debug('Branch ' . $inventory->branchName . ' not found');
                throw new Exception('Branch ' . $inventory->branchName . ' not found');
            }

            try {
                Inventory::updateOrCreate(
                    ['product_id' => $productId, 'branch_id' => $branchId],
                    ['sale_price' => $inventory->cost, 'quantity' => $inventory->onHand]
                );
            } catch (QueryException $e) {
                \Log::debug('Cannot save inventory: ' . $e->getMessage());
                throw $e;
            }
        }
    }
}
