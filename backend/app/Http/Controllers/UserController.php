<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Product;
use App\Models\Customer;

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
                'masterProduct.images',
                'subProducts.images'
            )
            ->whereHas('productLikers', function ($query) use ($user) {
                return $query->whereUserId($user->id);
            })
            ->paginate(20);

            return response()->json($products, 200);
        }

        return response()->json([], 200);
    }

    public function getDeliveryInfo()
    {
        $auth = new Auth;

        $user = $auth::guard()->user();

        if ($user) {
            $user = User::with('customer')->find($user->id)->first();

            return response()->json($user, 200);
        }

        return response()->json(null, 200);
    }
}
