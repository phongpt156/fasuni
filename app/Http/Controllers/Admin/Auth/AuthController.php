<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;

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

        if ($user && $user->is_admin) {
            return response()->json($user, 200);
        }
        return response()->json([], 401);
    }

    public function guard()
    {
        return $this->auth::guard();
    }
}
