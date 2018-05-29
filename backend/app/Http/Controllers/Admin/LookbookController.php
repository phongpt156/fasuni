<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lookbook;
use App\Models\ProductLookbook;
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
        $lookbookPath = config('path.images') . 'lookbooks' . DIRECTORY_SEPARATOR;

        $originalPath = $lookbookPath . 'original';
        $smPath = 'lookbooks/sm/';
        $mdPath = $lookbookPath . 'md';
        $lgPath = $lookbookPath . 'lg';
        $thumbnailPath = $lookbookPath . 'thumbnail';

        ImageUtility::resize($request->image, $lookbookPath);

        $lookbook = new Lookbook;
        $lookbook->name = $request->name;
        $lookbook->original_image = $request->image;
        $lookbook->small_image = 'lookbooks/sm/' . $request->image;
        $lookbook->medium_image = 'lookbooks/md/' . $request->image;
        $lookbook->large_image = 'lookbooks/lg/' . $request->image;
        $lookbook->thumbnail = 'lookbooks/thumbnail/' . $request->image;

        try {
            $lookbook->save();
        } catch (QueryException $e) {
            \Log::debug('Cannot save lookbook: ' . $e->getMessage());
            return response()->json(['error' => 'Cannot save lookbook: ' . $e->getMessage()], 500);
        }

        foreach ($request->products as $product) {
            $productLookbook = new ProductLookbook;
            $productLookbook->product_id = $product;
            $productLookbook->lookbook_id = $lookbook->id;

            try {
                $productLookbook->save();
            } catch (QueryException $e) {
                \Log::debug('Cannot save product lookbook: ' . $e->getMessage());
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
}
