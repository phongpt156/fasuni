<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category', 'images', 'attributeValues.attribute', 'inventories', 'subProducts.images', 'subProducts.category', 'subProducts.attributeValues.attribute', 'subProducts.inventories')->whereNull('master_product_id')->orderBy('created_at', 'desc')->paginate(20);

        return response()->json($products, 200);
    }

    public function search(Request $request)
    {
        $products = Product::with('images')->whereNull('master_product_id');

        if ($request->has('name')) {
            $products = $products->where('name', 'LIKE', '%' . $request->name . '%');
        }

        $products = $products->orderBy('created_at', 'desc')->get();

        return response()->json($products, 200);
    }
}
