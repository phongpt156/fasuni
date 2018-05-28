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
                \Log::error('Cannot save product: ' . $e->getMessage());
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
            $attributeName = ucfirst(mb_strtolower($kiotVietAttribute['AttributeName']));
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
                    ['name' => $kiotVietAttribute['AttributeValue']],
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

    public function saveInventories(Array $inventories = [], int $productId, $kiotVietController)
    {
        foreach ($inventories as $inventory) {
            $branchId = $kiotVietController->getBranchId($inventory['BranchId']);

            try {
                Inventory::updateOrCreate(
                    ['product_id' => $productId, 'branch_id' => $branchId],
                    ['purchase_price' => $inventory['Cost'], 'quantity' => $inventory['OnHand']]
                );
            } catch (QueryException $e) {
                \Log::error('Cannot save inventory: ' . $e->getMessage());
                response()->json(['error' => 'Cannot save inventory: ' . $e->getMessage()], 500)->send();
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
            \Log::error('Cannot delete products: ' . $e->getMessage());
            return response()->json(['error' => 'Cannot delete products: ' . $e->getMessage()], 500);
        }
    }
}
