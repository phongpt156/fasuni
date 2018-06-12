<?php

namespace App\DAL\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\QueryException;
use App\Exceptions\Auth\DuplicatePhoneNumberException;
use App\PackageWrapper\Token;

class RegisterDAL
{
    public function index($credentials)
    {
        $userModel = new User;

        $user = $userModel::where('phone_number', $credentials['phone_number'])->first();
        if ($user) {
            throw new DuplicatePhoneNumberException;
        }

        $user = $userModel;
        $user->phone_number = $credentials['phone_number'];      
        $user->password = Hash::make($credentials['password']);
        $user->first_name = $credentials['first_name'];
        $user->last_name = $credentials['last_name'];
        $user->living_city_id = $credentials['city_id'];
        $user->gender = $credentials['gender'];
        $user->api_token = (new Token)->getToken($userModel->getTable(), $userModel->getTable() . '.api_token', 60);

        try {
            $user->save();
        } catch (QueryException $e) {
            \Log::error($e->getFile() . ' ' . $e->getLine() . ' error: ' . $e->getMessage());
        }

        return $user->makeVisible('api_token');
    }
}
