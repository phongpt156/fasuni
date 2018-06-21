<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Order;
use App\Models\UserDeliveryInfo;

class UserController extends Controller
{
    public function getInfoOfUser()
    {
        $auth = new Auth;

        $user = $auth::guard()->user();

        if ($user) {
            $info = UserDeliveryInfo::whereUserId($user->id)->first();

            return response()->json($info, 200);
        }

        return response(null, 401);
    }
}
