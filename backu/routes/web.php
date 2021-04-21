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


// API route group
$router->group(['prefix' => 'api'], function () use ($router) {
    // Matches "/api/register
   $router->post('register', 'AuthController@register');
     // Matches "/api/login
    $router->post('login', 'AuthController@login');

    // Matches "/api/profile
    $router->get('profile', 'UserController@profile');

    // Matches "/api/user 
    //get one user by id
    $router->get('users/{id}', 'UserController@singleUser');

    // Matches "/api/users
    $router->get('users', 'UserController@allUsers');

    
    // Matches "/api/users
    $router->get('patients', 'PatientController@index');

    // Matches "/api/users
    $router->post('patients', 'PatientController@store');
    $router->put('patients/{id}', 'PatientController@update');

    // Matches "/api/users
    $router->get('patient_detail/{id}', 'PatientController@getPatientDetail');

    $router->post('entry_log', 'EntryController@store');
    $router->post('entry_log2', 'EntryController@entry_log2');

    
    $router->get('get_log/{id}', 'EntryController@getTodaysLog');
    $router->post('add_assessment', 'SelfassessmentController@store');

    $router->post('history', 'EntryController@getHistory');
    
    
});
