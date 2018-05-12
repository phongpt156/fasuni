<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with(
            'category',
            'images',
            'inventories',
            'subProducts.images',
            'subProducts.category',
            'subProducts.inventories'
        )
            ->whereNull('master_product_id')
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        $products->each(function ($product) {
            $product->append('size', 'color');
            $product->subProducts->each(function ($subProduct) {
                $subProduct->append('size', 'color');
            });
        });

        return response()->json($products, 200);
    }
}