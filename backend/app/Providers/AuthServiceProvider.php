<?php

namespace App\Providers;

use App\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Boot the authentication services for the application.
     *
     * @return void
     */
    public function boot()
    {
        // Here you may define how you wish users to be authenticated for your Lumen
        // application. The callback which receives the incoming request instance
        // should return either a User instance or null. You're free to obtain
        // the User instance via an API token or any other method necessary.

        $this->app['auth']->viaRequest('api', function ($request) {
            $token = '';

            if ($request->header('Authorization')) {
                $authorizeArray = explode(' ', $request->header('Authorization'));
                \Log::debug(count($authorizeArray));
                if (count($authorizeArray) > 1) {
                    $token = $authorizeArray[1];
                }
            }
            else if ($request->input('api_token')) {
                $token = $request->input('api_token');
            }
            if ($token) {
                $user = User::where('api_token', $token)->first();
                if ($user) {
                    return $user;
                }
            }
            return null;
        });
    }
}
