<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Collection;

class CollectionController extends Controller
{
    public function index()
    {
        $collections = Collection::latest()->paginate(5);

        return response()->json($collections, 200);
    }

    public function show($id)
    {
        $collection = Collection::whereId($id)->with('images', 'products', 'products.images', 'products.size', 'products.color')->first();

        return response()->json($collection, 200);
    }
}