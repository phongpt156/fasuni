<?php

namespace App\DAL\Admin\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Exceptions\Auth\IncorrectEmailException;
use App\Exceptions\Auth\IncorrectPasswordException;
use App\PackageWrapper\Token;
use App\PackageWrapper\DateTime;

class LoginDAL
{
    public function index($credentials)
    {
        $userModel = new User;

        $user = $userModel::where('email', $credentials['email'])->first();
        if ($user) {
            $isCorrectPassword = Hash::check($credentials['password'], $user->password);
            if ($isCorrectPassword) {
                $token = Token::getToken($userModel->getTable(), $userModel->getTable() . '.api_token', 60);
                $user->api_token = $token;
                $user->updated_at = DateTime::now();
                $user->save();
                return $user->makeVisible('api_token');
            }
            throw new IncorrectPasswordException;
        }
        throw new IncorrectEmailException;
    }
}
