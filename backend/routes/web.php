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

$router->get('/images/{filename}', function ($filename) use ($router) {
    $path = storage_path('app/images/' . $filename);
    $path = urldecode($path);

    if (Illuminate\Support\Facades\File::exists($path)) {
        $contentType = Illuminate\Support\Facades\File::mimeType($path);

        return response(Illuminate\Support\Facades\File::get($path), 200)->header('Content-Type', $contentType);
    }
    abort(401);
});

$router->get('/images/lookbooks/{size}/{filename}', function ($size, $filename) use ($router) {
    $path = storage_path('app/images/lookbooks/' . $size . '/' . $filename);
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
                $router->get('delete-all', 'WebhookController@deleteAll');

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
        $router->get('hierachy/{id}', 'CategoryController@getHierachyCategory');
    });
    $router->group(['prefix' => 'product'], function () use ($router) {
        $router->get('', 'ProductController@index');
        $router->get('category/{category}', 'ProductController@getByCategory');
        $router->get('relevant/{id}', 'ProductController@getRelevant');
        $router->get('{id}', 'ProductController@show');
    });
    $router->group(['prefix' => 'lookbook'], function () use ($router) {
        $router->get('get-male-month-list-snapshot', 'LookbookController@getMaleMonthListSnapshot');
        $router->get('get-female-month-list-snapshot', 'LookbookController@getFemaleMonthListSnapshot');
        $router->get('get-lookbooks-of-month/{gender}/{year}/{month}', 'LookbookController@getLookbooksOfMonth');
    });
    $router->group(['prefix' => 'attribute-value'], function () use ($router) {
        $router->get('color', 'AttributeValueController@getColors');
        $router->get('size', 'AttributeValueController@getSizes');
    });
    $router->get('like-product/{id}', 'ProductLikerController@like');
    $router->get('dislike-product/{id}', 'ProductLikerController@dislike');

    $router->get('test', 'Admin\SaleSoftware\KiotViet\KiotVietController@sync');
});

$router->get('/static/{type}/{file}', function ($type, $file) use ($router) {
    $path = resource_path('web/dist/static/' . $type . '/' . $file);

    if (Illuminate\Support\Facades\File::exists($path)) {
        $contentType = Illuminate\Support\Facades\File::mimeType($path);

        if ($type === 'css') {
            $contentType = 'text/css';
        }

        return response(Illuminate\Support\Facades\File::get($path), 200)->header('Content-Type', $contentType);
    }
});

$router->get('{any:.*}', 'HomeController@index');
