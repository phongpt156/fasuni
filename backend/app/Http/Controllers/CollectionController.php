<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Collection;

class CollectionController extends Controller
{
    public function index()
    {
        $collections = Collection::orderBy('created_at', 'desc')->paginate(5);

        return response()->json($collections, 200);
    }

    public function show($id)
    {
        $collection = Collection::whereId($id)->with('images', 'products', 'products.images')->first();

        $collection->products->each(function ($product) {
            $product->append('size', 'color');
        });

        return response()->json($collection, 200);
    }
}