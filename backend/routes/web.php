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

$router->get('/', function () use ($router) {
    return $router->app->version();
});
$router->group(['prefix' => 'api/v1', 'middleware' => 'cors'], function () use ($router) {

    $router->post('login', 'AuthController@login');
    $router->post('logout', 'AuthController@logout');
    $router->post('refresh', 'AuthController@refresh');
    $router->post('me', 'AuthController@me');

//Admin Routes
    $router->group(['prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => 'auth:api,admin'], function () use ($router) {
        $router->get('/', function () use ($router) {
            dd(auth()->user()->pluck('id','name'));
        });
        $router->get('users', 'UserController@index');

        //Posts Route
        $router->get('posts', 'PostController@index');
        $router->post('posts', 'PostController@store');
        $router->get('posts/{id}/show', 'PostController@show');
        $router->put('posts/{id}/update', 'PostController@update');
        $router->delete('posts/{id}/delete', 'PostController@destroy');
    });

});
