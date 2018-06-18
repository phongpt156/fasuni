<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lookbook;
use App\Models\ProductLookbook;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Utility\ImageUtility;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\File;

class LookbookController extends Controller
{
    public function index()
    {
        $lookbooks = Lookbook::all()->latest();

        return response()->json($lookbooks, 200);
    }

    public function show($id)
    {
        $lookbook = Lookbook::with('products', 'products.images', 'products.size', 'products.color')->find($id);

        return response()->json($lookbook, 200);
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
        }

        try {
            ProductLookbook::insert($products);
        } catch (QueryException $e) {
            \Log::error($e->getFile() . ' ' . $e->getLine() . ' error: Cannot save product lookbooks: ' . $e->getMessage());
            return response()->json(['error' => 'Cannot save product lookbooks: ' . $e->getMessage()], 500);
        }

        return response()->json($lookbook, 200);
    }

    public function update(Request $request, $id)
    {
        $lookbook = Lookbook::find($id);

        if ($request->has('image') && $request->image !== explode('lookbooks/', $lookbook->original_image)[1]) {
            $this->deleteImage($lookbook);
            ImageUtility::resize(config('path.image.lookbook') . $request->image, config('path.image.lookbook'));

            $lookbook->original_image = 'lookbooks/' . $request->image;
            $lookbook->small_image = 'lookbooks/sm/' . $request->image;
            $lookbook->medium_image = 'lookbooks/md/' . $request->image;
            $lookbook->large_image = 'lookbooks/lg/' . $request->image;
            $lookbook->thumbnail = 'lookbooks/thumbnail/' . $request->image;
        }
        $lookbook->name = $request->name;
        $lookbook->gender = $request->gender;

        try {
            $lookbook->save();
        } catch (QueryException $e) {
            \Log::error($e->getFile() . ' ' . $e->getLine() . ' error: Cannot update lookbook: ' . $e->getMessage());
            return response()->json(['error' => 'Cannot update lookbook: ' . $e->getMessage()], 500);
        }

        $oldProducts = ProductLookbook::whereLookbookId($id)->get()->pluck('product_id')->toArray();
        $removeProducts = array_diff($oldProducts, $request->products);
        $newProducts = array_diff($request->products, $oldProducts);

        try {
            ProductLookbook::whereIn('product_id', $removeProducts)->delete();
        } catch (QueryException $e) {
            \Log::error($e->getFile() . ' ' . $e->getLine() . ' error: Cannot delete old product lookbooks: ' . $e->getMessage());
            return response()->json(['error' => 'Cannot delete old product lookbooks: ' . $e->getMessage()], 500);
        }

        $products = [];
        foreach ($newProducts as $product) {
            array_push($products, [
                'product_id' => $product,
                'lookbook_id' => $lookbook->id
            ]);
        }

        try {
            ProductLookbook::insert($products);
        } catch (QueryException $e) {
            \Log::error($e->getFile() . ' ' . $e->getLine() . ' error: Cannot save product lookbooks: ' . $e->getMessage());
            return response()->json(['error' => 'Cannot save product lookbooks: ' . $e->getMessage()], 500);
        }

        return response()->json($lookbook, 200);
    }

    public function destroy($id)
    {
        $lookbook = Lookbook::find($id);
        $this->deleteImage($lookbook);

        try {
            Lookbook::destroy($id);
        } catch (QueryException $e) {
            \Log::error($e->getFile() . ' ' . $e->getLine() . ' error: Cannot delete lookbook: ' . $e->getMessage());
            return response()->json(['error' => 'Cannot delete lookbook: ' . $e->getMessage()], 500);
        }
    }

    public function deleteImage($lookbook)
    {
        File::delete(config('path.image.base') . $lookbook->original_image, config('path.image.base') . $lookbook->large_image, config('path.image.base') . $lookbook->medium_image, config('path.image.base') . $lookbook->small_image, config('path.image.base') . $lookbook->thumbnail);
    }

    public function getPrepareSaveName()
    {
        $count = Lookbook::count();

        return response()->json('Look ' . ($count + 1), 200);
    }

    public function searchProduct(Request $request)
    {

        $products = Product::with('images', 'size', 'color')
            ->whereIsActive(true)
            ->whereIsDisplay(true);

        $products->when($request->has('name'), function ($query) use ($request) {
            return $query-where('name', 'LIKE', '%' . $request->name . '%')
                ->orWhere('code', 'LIKE', '%' . $request->name . '%');
        });

        $products = $products->get();

        return response()->json($products, 200);
    }
}
