<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with(
            'category',
            'category.parent',
            'category.parent',
            'images',
            'attributeValues.attribute',
            'inventories',
            'subProducts.images',
            'subProducts.category',
            'subProducts.category.parent',
            'subProducts.category.parent',
            'subProducts.attributeValues.attribute',
            'subProducts.inventories'
            )
            ->whereNull('master_product_id')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return response()->json($products, 200);
    }

    public function update(Request $request, $id)
    {
        $product = Product::find($id);

        if ($product) {
            try {
                $product->fill($request->all());
                $product->save();

                return response()->json($product);
            } catch (QueryException $e) {
                \Log::error($e->getFile() . ' ' . $e->getLine() . ' error: Cannot update product: ' . $e->getMessage());

                return response()->json([
                    'error' => $e->getMessage()
                ]);
            }
        }

        return response()->json([
            'error' => 'Cannot find product'
        ]);
    }

    public function search(Request $request)
    {

        $products = Product::with(
            'category',
            'category.parent',
            'category.parent',
            'images',
            'attributeValues.attribute',
            'inventories',
            'subProducts.images',
            'subProducts.category',
            'subProducts.category.parent',
            'subProducts.category.parent',
            'subProducts.attributeValues.attribute',
            'subProducts.inventories'
            )
            ->whereNull('master_product_id')
            ->orderBy('created_at', 'desc');

        if ($request->has('name')) {
            $products = $products->where('name', 'LIKE', '%' . $request->name . '%')
            ->orWhere('code', 'LIKE', '%' . $request->name . '%');
        }

        $products = $products->paginate(20);
        $products->appends($request->except('page'))->links();

        return response()->json($products, 200);
    }
}
