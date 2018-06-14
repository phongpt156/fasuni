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
        ImageUtility::resize(config('path.image.lookbook') . $request->image, config('path.image.lookbook'));

        $lookbook = new Lookbook;
        $lookbook->name = $request->name;
        $lookbook->gender = $request->gender;
        $lookbook->original_image = 'lookbooks/' . $request->image;
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

        $products = [];
        foreach ($request->products as $product) {
            array_push($products, [
                'product_id' => $product,
                'lookbook_id' => $lookbook->id
            ]);

            try {
                ProductLookbook::insert($products);
            } catch (QueryException $e) {
                \Log::error($e->getFile() . ' ' . $e->getLine() . ' error: Cannot save product lookbooks: ' . $e->getMessage());
                return response()->json(['error' => 'Cannot save product lookbooks: ' . $e->getMessage()], 500);
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

        $products->when($request->has('name'), function ($query) use ($request) {
            return $query-where('name', 'LIKE', '%' . $request->name . '%')
                ->orWhere('code', 'LIKE', '%' . $request->name . '%');
        });

        $products = $products->get();

        $products->each(function ($product) {
            $product->append('size', 'color');
        });

        return response()->json($products, 200);
    }
}
