<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Collection;
use App\Models\CollectionImage;
use App\Models\ProductCollection;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Utility\ImageUtility;
use Illuminate\Database\QueryException;

class CollectionController extends Controller
{
    public function index()
    {
        $collections = Collection::all();

        return response()->json($collections, 200);
    }

    public function store(Request $request)
    {
        ImageUtility::resize(config('path.image.collection') . $request->cover[0]['response']['url'], config('path.image.collection'));

        $collection = new Collection;
        $collection->name = $request->name;
        $collection->description = $request->description;
        $collection->original_cover = 'collections/' . $request->cover[0]['response']['url'];
        $collection->small_cover = 'collections/sm/' . $request->cover[0]['response']['url'];
        $collection->medium_cover = 'collections/md/' . $request->cover[0]['response']['url'];
        $collection->large_cover = 'collections/lg/' . $request->cover[0]['response']['url'];
        $collection->thumbnail_cover = 'collections/thumbnail/' . $request->cover[0]['response']['url'];

        try {
            $collection->save();
        } catch (QueryException $e) {
            \Log::error($e->getFile() . ' ' . $e->getLine() . ' error: Cannot save collection: ' . $e->getMessage());
            return response()->json(['error' => 'Cannot save collection: ' . $e->getMessage()], 500);
        }

        $images = [];
        foreach ($request->images as $image) {
            array_push($images, [
                'original' => 'collections/' . $image['response']['url'],
                'collection_id' => $collection->id
            ]);
        }

        try {
            CollectionImage::insert($images);
        } catch (QueryException $e) {
            \Log::error($e->getFile() . ' ' . $e->getLine() . ' error: Cannot save collection images: ' . $e->getMessage());
            return response()->json(['error' => 'Cannot save collection images: ' . $e->getMessage()], 500);
        }

        $products = [];
        foreach ($request->products as $product) {
            array_push($products, [
                'product_id' => $product,
                'collection_id' => $collection->id
            ]);
        }

        try {
            ProductCollection::insert($products);
        } catch (QueryException $e) {
            \Log::error($e->getFile() . ' ' . $e->getLine() . ' error: Cannot save product collections: ' . $e->getMessage());
            return response()->json(['error' => 'Cannot save product collections: ' . $e->getMessage()], 500);
        }

        return response()->json($collection, 200);
    }
}
