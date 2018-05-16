<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Auth\AuthController;
use App\Models\ProductLiker;
use App\Models\Product;
use DB;

class ProductLikerController extends Controller
{
    public function like($productId)
    {
        $authController = new AuthController(new Auth);
        $user = $authController->user();

        if ($user) {
            try {
                DB::transaction(function () use ($productId, $user) {
                    ProductLiker::updateOrCreate(
                        ['product_id' => $productId, 'user_id' => $user->id]
                    );
                    Product::find($productId)->increment('like_count');
                });
            } catch (QueryException $e) {
                return response()->json(['error' => $e->getMessage()], 500);
            }

            return response()->json(['status' => 'Success'], 200);
        }

        return response()->json(['error' => 'Bạn chưa đăng nhập'], 401);
    }

    public function dislike($productId)
    {
        $authController = new AuthController(new Auth);
        $user = $authController->user();

        if ($user) {
            try {
                DB::transaction(function () use ($productId, $user) {
                    ProductLiker::whereProductId($productId)->whereUserId($user->id)->delete();
                    Product::find($productId)->decrement('like_count');
                });
            } catch (QueryException $e) {
                return response()->json(['error' => $e->getMessage()], 500);
            }

            return response()->json(['status' => 'Success'], 200);
        }

        return response()->json(['error' => 'Bạn chưa đăng nhập'], 401);
    }
}
