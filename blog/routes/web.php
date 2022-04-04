<?php

use App\Http\Controllers\RdvController;
use Illuminate\Support\Facades\Mail;

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

$router->group(['prefix' => 'auth'], function () use ($router) {

    $router->post('register_client', 'AuthController@register_client');
    $router->post('login_client', 'AuthController@login_client');
    $router->post('register_employee', 'AuthController@register_employee');
    $router->post('login_employee', 'AuthController@login_employee');
});

$router->group(['prefix' => 'client'], function () use ($router) {

    $router->get('/favorites', 'FavoriteListController@showFavoriteList');
    $router->post('/favorites', 'FavoriteListController@createFavoriteList');
    $router->delete('/favorites/{id}', 'FavoriteListController@deleteFavoriteList');
    $router->post('/documents', 'ClientController@upload');
    $router->delete('/documents/{id}', 'ClientController@deleteFile');
    $router->put('/documents/{id}', 'ClientController@updateFile');
    $router->get('/documents', 'ClientController@readFiles');
    $router->get('/{id}', 'ClientController@singleClient');
    $router->get('/', 'ClientController@allClients');
    $router->delete('/{id}', 'ClientController@deleteClient');
    $router->put('/{id}', 'ClientController@updateClient');
});

$router->group(['prefix' => 'property'], function () use ($router) {

    $router->post('/', 'PropertyController@create');
    $router->post('/pictures', 'PropertyController@uploadPropertyPictures');
    $router->post('/energy-audit', 'PropertyController@uploadEnergyAudit');

    $router->get('/{id}', 'PropertyController@singleProperty');
    $router->get('/', 'PropertyController@allProperties');
    $router->put('/{id}', 'PropertyController@updateProperty');
});

$router->post('rdv', 'RdvController@createRdv');
