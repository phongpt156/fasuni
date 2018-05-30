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

$router->get('/images/{filename}', function ($filename) use ($router) {
    $path = config('path.images') . $filename;
    $path = urldecode($path);

    if (Illuminate\Support\Facades\File::exists($path)) {
        $contentType = Illuminate\Support\Facades\File::mimeType($path);

        return response(Illuminate\Support\Facades\File::get($path), 200)->header('Content-Type', $contentType);
    }
});

$router->get('/images/lookbooks/{size}/{filename}', function ($size, $filename) use ($router) {
    $path = config('path.images') . DIRECTORY_SEPARATOR . 'lookbooks' . DIRECTORY_SEPARATOR . $size . DIRECTORY_SEPARATOR . $filename;
    $path = urldecode($path);

    if (Illuminate\Support\Facades\File::exists($path)) {
        $contentType = Illuminate\Support\Facades\File::mimeType($path);

        return response(Illuminate\Support\Facades\File::get($path), 200)->header('Content-Type', $contentType);
    }
});

$router->group(['prefix' => 'api'], function () use ($router) {
    $router->group(['prefix' => 'admin', 'namespace' => 'Admin'], function () use ($router) {
        $router->group(['prefix' => 'auth', 'namespace' => 'Auth'], function () use ($router) {
            $router->post('login', 'LoginController@index');
            $router->get('', 'AuthController@index');
        });
        $router->group(['prefix' => 'category'], function () use ($router) {
            $router->get('', 'CategoryController@index');
        });
        $router->group(['prefix' => 'product'], function () use ($router) {
            $router->get('', 'ProductController@index');
            $router->get('search', 'ProductController@search');
        });
        $router->group(['prefix' => 'attribute'], function () use ($router) {
            $router->get('', 'AttributeController@index');
        });
        $router->group(['prefix' => 'customer'], function () use ($router) {
            $router->get('', 'CustomerController@index');
        });
        $router->group(['prefix' => 'image'], function () use ($router) {
            $router->post('upload', 'ImageController@upload');
            $router->delete('delete/{url}', 'ImageController@delete');
        });
        $router->group(['prefix' => 'lookbook'], function () use ($router) {
            $router->get('', 'LookbookController@index');
            $router->post('', 'LookbookController@store');
            $router->get('get-prepare-save-name', 'LookbookController@getPrepareSaveName');
        });
        $router->group(['prefix' => 'kiotviet', 'namespace' => 'SaleSoftware\KiotViet'], function () use ($router) {
            $router->get('sync', 'KiotVietController@sync');
            $router->get('sync-locations', 'KiotVietController@syncLocations');

            $router->group(['prefix' => 'webhook', 'namespace' => 'Webhook'], function () use ($router) {
                $router->get('register', 'WebhookController@register');
                $router->delete('delete-all', 'WebhookController@deleteAll');

                $router->group(['prefix' => 'customer'], function () use ($router) {
                    $router->post('update', 'CustomerController@update');
                    $router->post('destroy', 'CustomerController@destroy');
                });
                $router->group(['prefix' => 'product'], function () use ($router) {
                    $router->post('update', 'ProductController@update');
                    $router->post('destroy', 'ProductController@destroy');
                });
                $router->group(['prefix' => 'inventory'], function () use ($router) {
                    $router->post('update', 'InventoryController@update');
                });
                $router->group(['prefix' => 'order'], function () use ($router) {
                    $router->post('update', 'OrderController@update');
                });
                $router->group(['prefix' => 'invoice'], function () use ($router) {
                    $router->post('update', 'InvoiceController@update');
                });
            });
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
        $router->group(['prefix' => 'google', 'namespace' => 'Google'], function () use ($router) {
            $router->post('login', 'GoogleController@login');
        });
    });
    $router->group(['prefix' => 'city'], function () use ($router) {
        $router->get('', 'CityController@index');
    });
    $router->group(['prefix' => 'category'], function () use ($router) {
        $router->get('', 'CategoryController@index');
    });
    $router->group(['prefix' => 'product'], function () use ($router) {
        $router->get('', 'ProductController@index');
        $router->get('{id}', 'ProductController@show');
    });
    $router->group(['prefix' => 'lookbook'], function () use ($router) {
        $router->get('get-male-month-list-snapshot', 'LookbookController@getMaleMonthListSnapshot');
        $router->get('get-female-month-list-snapshot', 'LookbookController@getFemaleMonthListSnapshot');
    });
    $router->get('like-product/{id}', 'ProductLikerController@like');
    $router->get('dislike-product/{id}', 'ProductLikerController@dislike');

    $router->get('test', 'Admin\SaleSoftware\KiotViet\KiotVietController@sync');
});
