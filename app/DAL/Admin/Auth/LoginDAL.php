<?php

namespace App\DAL\Admin\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\QueryException;
use App\Exceptions\Auth\IncorrectEmailException;
use App\Exceptions\Auth\IncorrectPasswordException;

class LoginDAL
{
    public function index($credentials)
    {
        $userModel = new User;

        $user = $userModel::where('email', $credentials['email'])->first();
        if ($user) {
            $isCorrectPassword = Hash::check($credentials['password'], $user->password);
            if ($isCorrectPassword) {
                try {
                    $user->save();
                } catch (QueryException $e) {
                    \Log::error($e->getFile() . ' ' . $e->getLine() . ' error: ' . $e->getMessage());
                }

                return $user->makeVisible('api_token');
            }
            throw new IncorrectPasswordException;
        }
        throw new IncorrectEmailException;
    }
}
