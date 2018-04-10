<?php

namespace App\DAL;

use App\Models\User;
use App\PackageWrapper\DateTime;
use App\PackageWrapper\Token;

class UserDAL
{
    public function store($data)
    {
        $user = User::where('email', $data['email'])->first();
        if ($user) {
            $data['email'] = null;
        }

        $userModel = new User;

        $user = $userModel->fill($data);
        $user->api_token = (new Token)->getToken($userModel->getTable(), $userModel->getTable() . '.api_token', 60);
        $user->created_at = $user->updated_at = DateTime::now();
        $user->save();

        return $user->makeVisible('api_token');
    }

    public function update($user, $data)
    {
        $userModel = new User;

        $user->fill($data);
        $user->api_token = (new Token)->getToken($userModel->getTable(), $userModel->getTable() . '.api_token', 60);
        $user->updated_at = DateTime::now();
        $user->save();

        return $user->makeVisible('api_token');
    }

    public function getUserByFacebookId($facebookId)
    {
        $user = User::where('facebook_id', $facebookId)->first();

        return $user;
    }
}
