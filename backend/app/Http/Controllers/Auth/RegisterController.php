<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DAL\Auth\RegisterDAL as RegisterDAL;
use App\Exceptions\Auth\DuplicatePhoneNumberException;

class RegisterController extends Controller
{
    public function index(Request $request)
    {
        $this->validate($request, [
            'phone_number' => 'required',
            'password' => 'required'
        ]);

        $credentials = $request->only('phone_number', 'password', 'city_id', 'gender', 'first_name', 'last_name');
        $registerDAL = new RegisterDAL;

        try {
            $user = $registerDAL->index($credentials);
            return response()->json($user, 200);
        } catch (DuplicatePhoneNumberException $e) {
            $errors['phone_number'] = $e->getMessage();
            $code = $e->getCode();
        }
        return response()->json(['errors' => $errors], $code);
    }
}
