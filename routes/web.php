<?php

/** @var \Laravel\Lumen\Routing\Router $router */

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

$router->get(
    '/', function () use ($router) {
        return $router->app->version();
    }
);

$router->group(
    ['prefix' => 'product', 'middleware' => ['auth:api']], function () use ($router) {
        $router->post('create',     'ProductController@create');
        $router->get('read',        'ProductController@read');
        $router->post('update',     'ProductController@update');
        $router->delete('delete',   'ProductController@delete');
    }
);

$router->group(
    ['prefix' => 'translation', 'middleware' => ['auth:api']], function () use ($router) {
        $router->post('create',     'TranslationController@create');
        $router->get('read',        'TranslationController@read');
        $router->post('update',     'TranslationController@update');
        $router->delete('delete',   'TranslationController@delete');
    }
);

