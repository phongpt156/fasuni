<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\Auth\AuthController;
use Illuminate\Http\Request;
use App\DAL\LoginDAL as LoginDAL;
use App\Exceptions\Auth\IncorrectEmailException;
use App\Exceptions\Auth\IncorrectPasswordException;

class LoginController extends AuthController
{
    public function index(Request $request)
    {
        $this->validate($request, [
            'email' => 'required',
            'password' => 'required'
        ]);

        $credentials = $request->only('email', 'password');
        $loginDAL = new LoginDAL();
        try {
            $user = $loginDAL->index($credentials);
            return response()->json($user, 200);
        } catch (IncorrectEmailException $e) {
            $errors['email'] = $e->getMessage();
            $code = $e->getCode();
        } catch (IncorrectPasswordException $e) {
            $errors['password'] = $e->getMessage();
            $code = $e->getCode();
        }
        return response()->json($errors, $code);
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => $this->guard()->factory()->getTTL() * 60
        ]);
    }
}
