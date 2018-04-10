<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group(['prefix' => 'api'], function () use ($router) {
    $router->group(['prefix' => 'admin', 'namespace' => 'Admin'], function () use ($router) {
        $router->group(['prefix' => 'auth', 'namespace' => 'Auth'], function () use ($router) {
            $router->post('login', 'LoginController@index');
            $router->get('', 'AuthController@index');
        });
    });

    $router->group(['prefix' => 'auth', 'namespace' => 'Auth'], function () use ($router) {
        $router->get('', 'AuthController@index');
        $router->post('register', 'RegisterController@index');
        $router->post('login', 'LoginController@index');
        $router->get('logout', 'AuthController@logout');

        $router->group(['prefix' => 'facebook', 'namespace' => 'Facebook'], function () use ($router) {
            $router->post('login', 'FacebookController@login');
        });
    });
    $router->group(['prefix' => 'city'], function () use ($router) {
        $router->get('', 'CityController@index');
    });
});
