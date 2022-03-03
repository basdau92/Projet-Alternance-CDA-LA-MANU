<?php

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

    $router->post('register', 'AuthController@register');
    $router->post('login', 'AuthController@login');
});

$router->group(['prefix' => 'client'], function () use ($router) {

    $router->get('/my-favorites', 'FavoriteListController@showFavoriteList');
    $router->post('/add-favorites', 'FavoriteListController@createFavoriteList');
    $router->delete('delete-favorites/{id}', 'FavoriteListController@deleteFavoriteList');
    $router->post('/new-documents', 'ClientController@upload');
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

$router->get('send-mail', function () {
   
    $details = [
        'title' => 'Mail from test.com',
        'body' => 'This is for testing email using smtp'
    ];
   
    Mail::to('inesbkht@gmail.com')->send(new \App\Mail\TestMail($details));
   
    dd("Email is Sent.");
});