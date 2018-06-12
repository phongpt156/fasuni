<?php

namespace App\Http\Controllers\Admin\SaleSoftware\KiotViet\Webhook;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\SaleSoftware\KiotViet\KiotVietController;
use Illuminate\Database\QueryException;
use App\Models\Product;
use App\Models\Inventory;
use App\Models\ProductImage;
use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\ProductAttributeValue;

class ProductController extends WebhookController
{
    public function update(Request $request)
    {
        \Log::debug('updated product');

        $products = $this->getRequestData($request);

        $kiotVietController = new KiotVietController($this->kiotVietService);

        foreach ($products as $product) {
            $categoryId = $kiotVietController->getCategoryId($product['CategoryId']);

            if (is_null($product['MasterProductId'])) {
                $masterProductId = null;
            } else {
                $masterProductId = $kiotVietController->getProductId($product['MasterProductId']);
            }

            try {
                $savedProduct = Product::updateOrCreate(
                    ['kiotviet_id' => $product['Id']],
                    ['name' => $product['Name'], 'sale_price' => $product['BasePrice'], 'weight' => $product['Weight'], 'code' => $product['Code'], 'slug' => str_slug($product['Name']), 'category_id' => $categoryId, 'master_product_id' => $masterProductId, 'is_active' => $product['isActive']]
                );
            } catch (QueryException $e) {
                \Log::error($e->getFile() . ' ' . $e->getLine() . ' error: Cannot save product: ' . $e->getMessage());
                throw $e;
            }

            if (!is_null($product['Attributes'])) {
                $this->saveAttributes($product['Attributes'], $savedProduct->id);
            }

            if (!is_null($product['Images'])) {
                $this->saveImages($product['Images'], $savedProduct->id);
            }

            if (!is_null($product['Inventories'])) {
                $this->saveInventories($product['Inventories'], $savedProduct->id, $kiotVietController);
            }
        }
    }

    public function saveImages(Array $images = [], int $productId)
    {
        $oldProductImages = ProductImage::whereProductId($productId)->get()->pluck('original')->toArray();
        $removeImages = array_diff($oldProductImages, $images);

        if (count($removeImages)) {
            try {
                ProductImage::whereIn('original', $removeImages)->delete();
            } catch (QueryException $e) {
                \Log::error($e->getFile() . ' ' . $e->getLine() . ' error: Cannot delete product images: ' . $e->getMessage());
                response()->json(['error' => 'Cannot delete product images: ' . $e->getMessage()], 500)->send();
                die;
            }
        }

        foreach ($images as $image) {
            try {
                ProductImage::updateOrCreate(
                    ['original' => $image],
                    ['product_id' => $productId]
                );
            } catch (QueryException $e) {
                \Log::error($e->getFile() . ' ' . $e->getLine() . ' error: Cannot save product image: ' . $e->getMessage());
                response()->json(['error' => 'Cannot save product image: ' . $e->getMessage()], 500)->send();
                die;
            }
        }
    }

    public function saveAttributes(Array $attributes = [], int $productId)
    {
        $oldAttributeValues = AttributeValue::whereHas('products', function ($query) use ($productId) {
            $query->where('id', $productId);
        })->get()->pluck('name')->toArray();
        $newAttributeValues = collect($attributes)->pluck('attributeValue')->toArray();
        $removeAttributeValues = array_diff($oldAttributeValues, $newAttributeValues);

        if (count($removeAttributeValues)) {
            try {
                ProductAttributeValue::whereProductId($productId)->whereHas('attributeValue', function ($query) use ($removeAttributeValues) {
                    $query->whereIn('name', $removeAttributeValues);
                })->delete();
            } catch (QueryException $e) {
                \Log::error($e->getFile() . ' ' . $e->getLine() . ' error: Cannot delete product attributes: ' . $e->getMessage());
                response()->json(['error' => 'Cannot delete product attributes: ' . $e->getMessage()], 500)->send();
                die;
            }
        }

        foreach ($attributes as $kiotVietAttribute) {
            $attributeName = ucfirst(mb_strtolower($kiotVietAttribute['AttributeName']));
            try {
                $attribute = Attribute::updateOrCreate(
                    ['name' => $attributeName]
                );
            } catch (QueryException $e) {
                \Log::error($e->getFile() . ' ' . $e->getLine() . ' error: Cannot save attribute: ' . $e->getMessage());
                response()->json(['error' => 'Cannot save attribute: ' . $e->getMessage()], 500)->send();
                die;
            }

            try {
                $attributeValue = AttributeValue::updateOrCreate(
                    ['name' => $kiotVietAttribute['AttributeValue']],
                    ['attribute_id' => $attribute->id]
                );
            } catch (QueryException $e) {
                \Log::error($e->getFile() . ' ' . $e->getLine() . ' error: Cannot save attribute value: ' . $e->getMessage());
                response()->json(['error' => 'Cannot save attribute value: ' . $e->getMessage()], 500)->send();
                die;
            }

            try {
                ProductAttributeValue::updateOrCreate(
                    ['product_id' => $productId, 'attribute_value_id' => $attributeValue->id]
                );
            } catch (QueryException $e) {
                \Log::error($e->getFile() . ' ' . $e->getLine() . ' error: Cannot save product attribute value: ' . $e->getMessage());
                response()->json(['error' => 'Cannot save product attribute value: ' . $e->getMessage()], 500)->send();
                die;
            }
        }
    }

    public function saveInventories(Array $inventories = [], int $productId, $kiotVietController)
    {
        $newBranchIds = [];
        $oldBranchIds = Inventory::whereProductId($productId)->get()->pluck('branch_id')->toArray();

        foreach ($inventories as $inventory) {
            $branchId = $kiotVietController->getBranchId($inventory['BranchId']);
            array_push($newBranchIds, $branchId);

            try {
                Inventory::updateOrCreate(
                    ['product_id' => $productId, 'branch_id' => $branchId],
                    ['purchase_price' => $inventory['Cost'], 'quantity' => $inventory['OnHand']]
                );
            } catch (QueryException $e) {
                \Log::error($e->getFile() . ' ' . $e->getLine() . ' error: Cannot save inventory: ' . $e->getMessage());
                response()->json(['error' => 'Cannot save inventory: ' . $e->getMessage()], 500)->send();
                die;
            }
        }

        $removeIds = array_diff($oldBranchIds, $newBranchIds);
        if (count($removeIds)) {
            try {
                Inventory::whereProductId($productId)->whereIn('branch_id', $removeIds)->delete();
            } catch (QueryException $e) {
                \Log::error($e->getFile() . ' ' . $e->getLine() . ' error: Cannot delete inventories: ' . $e->getMessage());
                response()->json(['error' => 'Cannot delete inventories: ' . $e->getMessage()], 500)->send();
                die;
            }
        }
    }

    public function destroy(Request $request)
    {
        \Log::debug(['deleted product', $request->all()]);

        $kiotVietIds = $this->getRequestData($request);

        try {
            Product::whereIn('kiotviet_id', $kiotVietIds)->delete();
        } catch (QueryException $e) {
            \Log::error($e->getFile() . ' ' . $e->getLine() . ' error: Cannot delete products: ' . $e->getMessage());
            return response()->json(['error' => 'Cannot delete products: ' . $e->getMessage()], 500);
        }
    }
}
