<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DAL\Auth\LoginDAL as LoginDAL;
use App\Exceptions\Auth\IncorrectPhoneNumberException;
use App\Exceptions\Auth\IncorrectPasswordException;

class LoginController extends Controller
{
    public function index(Request $request)
    {
        $this->validate($request, [
            'phone_number' => 'required',
            'password' => 'required'
        ]);

        $credentials = $request->only('phone_number', 'password');
        $loginDAL = new LoginDAL();
        try {
            $user = $loginDAL->index($credentials);
            return response()->json($user, 200);
        } catch (IncorrectPhoneNumberException $e) {
            $errors['email'] = $e->getMessage();
            $code = $e->getCode();
        } catch (IncorrectPasswordException $e) {
            $errors['password'] = $e->getMessage();
            $code = $e->getCode();
        }
        return response()->json(['errors' => $errors], $code);
    }
}
