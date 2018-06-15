<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Product;

class UserController extends Controller
{
    public function getWhistlist()
    {
        $auth = new Auth;

        $user = $auth::guard()->user();
        $products = [];

        if ($user) {
            $products = Product::with(
                'images',
                'color',
                'masterProduct.images',
                'masterProduct.color',
                'subProducts.images',
                'subProducts.color'
            )
            ->whereHas('productLikers', function ($query) use ($user) {
                return $query->whereUserId($user->id);
            })
            ->paginate(20);

            // $user->each(function ($user) use (&$products) {
            //     $products = $user->likedProducts;
            // });

            return response()->json($products, 200);
        }

        return response()->json([], 200);
    }
}
