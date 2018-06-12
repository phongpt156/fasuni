<?php

namespace App\Http\Controllers\Auth\Google;

use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use App\Exceptions\Auth\ExistEmailException;
use App\DAL\UserDAL;
use Google_Client;

class GoogleController
{
    private $client;

    public function __construct()
    {
        $this->client = new Google_Client([
            'client_id' => '493839488981-h84lbqckhj4ondu01sfc8ecfataevp3s.apps.googleusercontent.com'
        ]);
    }

    public function login(Request $request)
    {
        $userDAL = new UserDAL;

        $payload = $this->client->verifyIdToken($request->id_token);
        if ($payload) {
            $user = $userDAL->getUserByGoogleId($payload['sub']);

            $data = [
                'google_id' => $payload['sub'],
                'google_name' => $payload['name'],
                'google_id_token' => $request->id_token,
                'first_name' => isset($payload['given_name']) ? $payload['given_name']: '',
                'last_name' => isset($payload['family_name']) ? $payload['family_name']: '',
                'email' => $payload['email'],
                'avatar' => $payload['picture']
            ];

            if ($user) {
                try {
                    $user = $userDAL->update($user, $data);
                    return response()->json($user, 200);
                } catch (QueryException $e) {
                    \Log::error('Cannot update user: ' . $e->getMessage);
                    return response()->json(['error' => $e->getMessage()], 500);
                }
            } else {
                try {
                    $user = $userDAL->store($data);
                    return response()->json($user, 200);
                } catch (ExistEmailException $e) {
                    return response()->json(['error' => $e->getMessage()], $e->getCode());
                } catch (QueryException $e) {
                    \Log::error('Cannot save user: ' . $e->getMessage);
                    return response()->json(['error' => $e->getMessage()], 500);
                }
            }
        }
        return response()->json(['error' => 'Invalid user'], 401);
    }
}