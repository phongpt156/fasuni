<?php

namespace App\Http\Controllers\Auth\Facebook;

use Facebook\Facebook;
use Facebook\Exceptions\FacebookResponseException;
use Facebook\Exceptions\FacebookSDKException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Exceptions\Auth\ExistEmailException;
use App\DAL\UserDAL;
use App\Models\City;

class FacebookController
{
    private $fb;

    public function __construct()
    {
        $this->fb = new Facebook([
            'app_id' => env('FACEBOOK_APP_ID'),
            'app_secret' => env('FACEBOOK_APP_SECRET'),
            'default_graph_version' => env('FACEBOOK_DEFAULT_GRAPH_VERSION')
        ]);
    }

    public function login(Request $request)
    {
        $userDAL = new UserDAL;
        $data = $request->all();

        $cityId = City::where('name', 'like', '%' . $request->location)->pluck('id')->first();
        $user = $userDAL->getUserByFacebookId($request->facebook_id);

        if ($cityId) {
            $data['living_city_id'] = $cityId;
        }
        if ($user) {
            $user = $userDAL->update($user, $data);
        } else {
            try {
                $user = $userDAL->store($data);
            } catch (ExistEmailException $e) {
                return response()->json(['error' => $e->getMessage()], $e->getCode());
            }
        }

        return response()->json($user, 200);
    }
}