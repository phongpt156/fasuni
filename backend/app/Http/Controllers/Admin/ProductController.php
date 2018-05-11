<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category', 'images', 'attributeValues.attribute', 'inventories', 'subProducts.images', 'subProducts.category', 'subProducts.attributeValues.attribute', 'subProducts.inventories')->whereNull('master_product_id')->orderBy('created_at', 'desc')->paginate(20);

        return response()->json($products, 200);
    }
}
