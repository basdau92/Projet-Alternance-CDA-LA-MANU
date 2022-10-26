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

$router->group(['prefix' => 'authentification'], function () use ($router) {
    $router->get('/client', 'AuthController@loginClient');
    $router->get('/employee', 'AuthController@loginEmployee');
});

$router->group(['prefix' => 'register'], function () use ($router) {
    $router->post('/client', 'AuthController@registerClient');
    $router->post('/employee', 'AuthController@registerEmployee');
});

$router->group(['prefix' => 'employee'], function () use ($router) {
    $router->get('/', 'EmployeeController@allEmployees');
    $router->get('/dashboard', 'EmployeeController@singleEmployee');
    $router->get('/properties', 'EmployeeController@allProperties');
    $router->get('/my-properties', 'EmployeeController@allEmployeeProperties');
});

$router->group(['prefix' => 'customer'], function () use ($router) {
    $router->get('/my-favorite-list', 'FavoriteListController@showFavoriteList');
    $router->post('/new-favorite-list', 'FavoriteListController@createFavoriteList');
    $router->delete('/my-favorite-list/{id}', 'FavoriteListController@deleteFavoriteList');
    $router->post('/new-documents', 'ClientController@uploadFile');
    $router->delete('/document/{id}', 'ClientController@deleteFile');
    $router->put('/document/{id}', 'ClientController@updateFile');
    $router->get('/my-documents', 'ClientController@readFile');
    $router->get('/profile', 'ClientController@singleClient');
    $router->get('/', 'EmployeeController@allClients');
    $router->delete('/profile/{id}', 'ClientController@deleteClient');
    $router->put('/profile', 'ClientController@updateClient');
    $router->put('/profile/password', 'ClientController@updatePassword');

});

$router->group(['prefix' => 'property'], function () use ($router) {
    $router->post('/new', 'PropertyController@createProperty');
    $router->post('/pictures', 'PropertyController@uploadPropertyPictures');
    $router->post('/energy-audit', 'PropertyController@uploadEnergyAudit');
    $router->get('/{id}', 'PropertyController@singleProperty');
    $router->get('/', 'PropertyController@allProperties');
    $router->put('/{id}', 'PropertyController@updateProperty');
    $router->put('/status/{id}', 'PropertyController@updatePropertyStatus');
    $router->post('/send-mail', 'PropertyController@sendMailProperty');
    $router->get('/features', 'PropertyController@getPropertyFeatures');
    $router->get('/room-types', 'PropertyController@getPropertyRoomTypes');
    $router->get('/heaters', 'PropertyController@getPropertyHeaters');
    $router->get('/kitchens', 'PropertyController@getPropertyKitchens');
    $router->get('/categories', 'PropertyController@getPropertyCategories');
    $router->get('/types', 'PropertyController@getPropertyTypes');
});

$router->group(['prefix' => 'rdv'], function () use ($router) {
    $router->post('/new', 'RdvController@createRdv');
    $router->get('/', 'RdvController@showAuthEmployeeRdv');
    $router->get('/{id}', 'RdvController@employeeRdv');
    $router->get('/agency-{agencyId}', 'RdvController@getAgencyRdv');
});

$router->get('/contact', 'AgencyController@getAgencies');
