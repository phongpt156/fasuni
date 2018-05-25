<?php

namespace App\DAL;

use Illuminate\Database\QueryException;
use App\Exceptions\Auth\ExistEmailException;
use App\Models\User;
use App\PackageWrapper\Token;

class UserDAL
{
    public function store($data)
    {
        if ($data['email']) {
            $user = User::whereEmail($data['email'])->first();

            if ($user) {
                throw new ExistEmailException;
            }
        }

        $userModel = new User;

        $user = $userModel->fill($data);
        $user->api_token = (new Token)->getToken($userModel->getTable(), $userModel->getTable() . '.api_token', 60);

        try {
            $user->save();
        } catch (QueryException $e) {
            \Log::error($e->getMessage());
        }

        return $user->makeVisible('api_token');
    }

    public function update($user, $data)
    {
        $userModel = new User;

        $user->fill($data);
        $user->api_token = (new Token)->getToken($userModel->getTable(), $userModel->getTable() . '.api_token', 60);

        try {
            $user->save();
        } catch (QueryException $e) {
            \Log::error($e->getMessage());
        }

        return $user->makeVisible('api_token');
    }

    public function getUserByFacebookId($facebookId)
    {
        $user = User::where('facebook_id', $facebookId)->first();

        return $user;
    }

    public function getUserByGoogleId($googleId)
    {
        $user = User::where('google_id', $googleId)->first();

        return $user;
    }
}
