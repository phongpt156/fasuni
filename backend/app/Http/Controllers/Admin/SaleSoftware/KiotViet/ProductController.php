<?php

namespace App\Http\Controllers\Admin\SaleSoftware\KiotViet;

use App\Models\Product;
use App\Models\Category;

class ProductController
{
    public function saveProducts(Array $products = [])
    {
        foreach ($products as $kiotVietProduct) {
            $product = Product::whereKiotVietId($kiotVietProduct->id)->first();
            if (!$product) {
                $product = new Product;
            }

            $category = Category::whereKiotVietId($kiotVietProduct->categoryId)->first();
            if ($category) {
                $product->category_id = $category->id;
            }

            if ($kiotVietProduct->masterProductId) {
                $masterProduct = Product::whereKiotVietId($kiotVietProduct->id)->first();
            }

            Product::updateOrCreate(
                ['kiotviet_id' => $product->id],
                []
            );
        }
    }
}
