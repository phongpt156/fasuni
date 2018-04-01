<?php

namespace App\DAL;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Exceptions\Auth\IncorrectEmailException;
use App\Exceptions\Auth\IncorrectPasswordException;
use Dirape\Token\Token;

class LoginDAL
{
    public function index($credentials)
    {
        $userModel = new User();

        $user = $userModel::where('email', $credentials['email'])->first();
        if ($user) {
            $isCorrectPassword = Hash::check($credentials['password'], $user->password);
            if ($isCorrectPassword) {
                $token = (new Token)->Unique($userModel->getTable(), $userModel->getTable() . '.api_token', 60);
                $user->api_token = $token;
                $user->save();
                return $user->makeVisible('api_token');
            }
            throw new IncorrectPasswordException;
        }
        throw new IncorrectEmailException;
    }
}
