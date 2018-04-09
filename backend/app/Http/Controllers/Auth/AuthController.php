<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;
use App\PackageWrapper\DateTime;

class AuthController extends Controller
{
    protected $auth;

    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }

    public function index(Request $request)
    {
        $user = $this->guard()->user();

        if ($user) {
            return response()->json($user, 200);
        }
        return response()->json(false);
    }

    public function guard()
    {
        return $this->auth::guard();
    }

    public function logout()
    {
        $user = $this->guard()->user();
        if ($user) {
            $user->api_token = null;
            $user->updated_at = DateTime::now();
            $user->save();
            return response()->json();
        }
        return response()->json([], 500);
    }
}
