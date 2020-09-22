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

use App\Http\Controllers\ActorController;

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group(['prefix' => 'api/actors'], function () use ($router) {

    $router->get('/', 'ActorController@index');
    $router->post('/', 'ActorController@store');
    $router->put('/', 'ActorController@notAllowed');
    $router->patch('/', 'ActorController@notAllowed');
    $router->delete('/', 'ActorController@notAllowed');

    $router->get('/{id}/', 'ActorController@show');
    $router->post('/{id}/', 'ActorController@notAllowed');
    $router->put('/{id}/', 'ActorController@notAllowed');
    $router->patch('/{id}/', 'ActorController@modify');
    $router->delete('/{id}/', 'ActorController@delete');

});