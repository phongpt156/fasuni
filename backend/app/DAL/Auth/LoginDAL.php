<?php

namespace App\DAL\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\QueryException;
use App\Exceptions\Auth\IncorrectPhoneNumberException;
use App\Exceptions\Auth\IncorrectPasswordException;
use App\PackageWrapper\Token;
use App\PackageWrapper\DateTime;

class LoginDAL
{
    public function index($credentials)
    {
        $userModel = new User;

        $user = $userModel::where('phone_number', $credentials['phone_number'])->first();
        if ($user) {
            $isCorrectPassword = Hash::check($credentials['password'], $user->password);
            if ($isCorrectPassword) {
                $token = (new Token)->getToken($userModel->getTable(), $userModel->getTable() . '.api_token', 60);
                $user->api_token = $token;
                $user->updated_at = DateTime::now();

                try {
                    $user->save();
                } catch (QueryException $e) {
                    \Log::debug($e->getMessage());
                }

                return $user->makeVisible('api_token');
            }
            throw new IncorrectPasswordException;
        }
        throw new IncorrectPhoneNumberException;
    }
}
