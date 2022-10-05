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

$router->group(['prefix' => 'authentification'], function () use ($router) {

    $router->post('/', 'AuthController@register_client');
    $router->get('/', 'AuthController@login_client');
    $router->post('/employee', 'AuthController@register_employee');
    $router->get('/employee', 'AuthController@login_employee');
});

$router->group(['prefix' => 'employee'], function () use ($router) {
    $router->get('/', 'EmployeeController@allEmployees');
    $router->get('/dashboard', 'EmployeeController@singleEmployee');
    $router->get('/allProperties', 'EmployeeController@allProperties');
    $router->get('/properties', 'EmployeeController@allEmployeeProperties');


});

$router->group(['prefix' => 'customer'], function () use ($router) {

    $router->get('/favorites', 'FavoriteListController@showFavoriteList');
    $router->post('/favorites', 'FavoriteListController@createFavoriteList');
    $router->delete('/favorites/{id}', 'FavoriteListController@deleteFavoriteList');
    $router->post('/documents', 'ClientController@upload');
    $router->delete('/documents/{id}', 'ClientController@deleteFile');
    $router->put('/documents/{id}', 'ClientController@updateFile');
    $router->get('/documents', 'ClientController@readFiles');
    $router->get('/profile', 'ClientController@singleClient');
    $router->get('/', 'ClientController@allClients');
    $router->delete('/{id}', 'ClientController@deleteClient');
    $router->put('/profile', 'ClientController@updateClient');
    $router->put('/profile/password', 'ClientController@updatePassword');
});

$router->group(['prefix' => 'property'], function () use ($router) {

    $router->post('/new', 'PropertyController@create');
    $router->post('/pictures', 'PropertyController@uploadPropertyPictures');
    $router->post('/energy-audit', 'PropertyController@uploadEnergyAudit');

    $router->get('/types', 'PropertyController@getPropertyTypes');
    $router->get('/categories', 'PropertyController@getPropertyCategories');
    $router->get('/heaters', 'PropertyController@getPropertyHeaters');
    $router->get('/kitchens', 'PropertyController@getPropertyKitchens');
    $router->get('/{id}', 'PropertyController@singleProperty');
    $router->get('/', 'PropertyController@allProperties');
    $router->put('/{id}', 'PropertyController@updateProperty');
});

$router->group(['prefix' => 'rdv'], function () use ($router) {
    $router->post('/', 'RdvController@createRdv');
    $router->get('/', 'RdvController@showAuthEmployeeRdv');
    $router->get('/{id}', 'RdvController@employeeRdv');
});

$router->get('/contact','AgencyController@getAgencies');
