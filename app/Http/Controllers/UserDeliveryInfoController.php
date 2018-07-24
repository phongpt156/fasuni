<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Models\UserDeliveryInfo;

class UserDeliveryInfoController extends Controller
{
    public function store(Request $request)
    {
        $auth = new Auth;

        $user = $auth::guard()->user();

        if ($user) {

            $info = UserDeliveryInfo::whereUserId($user->id)->first();

            try {
                UserDeliveryInfo::updateOrCreate(
                    ['user_id' => $user->id],
                    ['receiver_name' => $request->receiver_name, 'receiver_phone' => $request->receiver_phone, 'receiver_district_id' => $request->receiver_district_id, 'receiver_ward_id' => $request->receiver_ward_id ?? null, 'receiver_address' => $request->receiver_address]
                );

                return response()->json(['status' => 'success'], 200);
            } catch (QueryException $e) {
                \Log::error($e->getFile() . ' ' . $e->getLine() . ' error: Cannot save user delivery info: ' . $e->getMessage());
                return response()->json(['error' => $e->getMessage()], 500);
            }

            return response()->json($info, 200);
        }

        return response(null, 401);
    }

    public function getInfoOfUser()
    {
        $auth = new Auth;

        $user = $auth::guard()->user();

        if ($user) {
            $info = UserDeliveryInfo::with('district')->whereUserId($user->id)->first();

            return response()->json($info, 200);
        }

        return response(null, 401);
    }
}
