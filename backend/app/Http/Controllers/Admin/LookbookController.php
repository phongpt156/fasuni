<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lookbook;
use App\Models\ProductLookbook;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Utility\ImageUtility;
use Illuminate\Database\QueryException;

class LookbookController extends Controller
{
    public function index()
    {
        $lookbooks = Lookbook::all();

        return response()->json($lookbooks, 200);
    }

    public function store(Request $request)
    {
        $lookbookPath = storage_path('app/images/lookbooks/');;

        $originalPath = $lookbookPath . 'original';
        $smPath = 'lookbooks/sm/';
        $mdPath = $lookbookPath . 'md';
        $lgPath = $lookbookPath . 'lg';
        $thumbnailPath = $lookbookPath . 'thumbnail';

        ImageUtility::resize($request->image, $lookbookPath);

        $lookbook = new Lookbook;
        $lookbook->name = $request->name;
        $lookbook->gender = $request->gender;
        $lookbook->original_image = $request->image;
        $lookbook->small_image = 'lookbooks/sm/' . $request->image;
        $lookbook->medium_image = 'lookbooks/md/' . $request->image;
        $lookbook->large_image = 'lookbooks/lg/' . $request->image;
        $lookbook->thumbnail = 'lookbooks/thumbnail/' . $request->image;

        try {
            $lookbook->save();
        } catch (QueryException $e) {
            \Log::error($e->getFile() . ' ' . $e->getLine() . ' error: Cannot save lookbook: ' . $e->getMessage());
            return response()->json(['error' => 'Cannot save lookbook: ' . $e->getMessage()], 500);
        }

        foreach ($request->products as $product) {
            $productLookbook = new ProductLookbook;
            $productLookbook->product_id = $product;
            $productLookbook->lookbook_id = $lookbook->id;

            try {
                $productLookbook->save();
            } catch (QueryException $e) {
                \Log::error($e->getFile() . ' ' . $e->getLine() . ' error: Cannot save product lookbook: ' . $e->getMessage());
                return response()->json(['error' => 'Cannot save product lookbook: ' . $e->getMessage()], 500);
            }
        }

        return response()->json($lookbook, 200);
    }

    public function getPrepareSaveName()
    {
        $count = Lookbook::count();

        return response()->json('Lookbook ' . ($count + 1), 200);
    }

    public function searchProduct(Request $request)
    {

        $products = Product::with('images')
            ->whereIsActive(true);

        if ($request->has('name')) {
            $products = $products->where('name', 'LIKE', '%' . $request->name . '%')
            ->orWhere('code', 'LIKE', '%' . $request->name . '%');
        }

        $products = $products->get();

        $products->each(function ($product) {
            $product->append('size', 'color');
        });

        return response()->json($products, 200);
    }
}
