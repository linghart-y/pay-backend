<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::group([
    'middleware' => 'api'
], function ($router) {
    Route::post('auth/registers', 'AuthController@registers');
    Route::post('auth/login', 'AuthController@login');
    Route::post('auth/logout', 'AuthController@logout');
    Route::post('auth/update', 'AuthController@update');
    Route::get('auth/refresh', 'AuthController@refresh');
    Route::get('auth/user', 'AuthController@user');
    Route::get('remittances', 'UserController@remittances');
    Route::get('in_remittances', 'UserController@in_remittances');
    Route::get('out_remittances', 'UserController@out_remittances');
    Route::get('get-persons', 'UserController@getPersons');
    Route::post('add-remittance', 'RemittanceController@addRemittance');
    Route::post('get_all_remittances', 'UserController@getAllRemittances');
    Route::post('from_template', 'RemittanceController@fromTemplate');
});

Route::group([
    'middleware' => 'api',
], function ($router) {
    Route::post('admin/get-person', 'AdminController@getPerson');
    Route::post('admin/get-payment', 'AdminController@getPayment');
    Route::post('admin/users-index', 'AdminController@usersIndex');
    Route::post('admin/remittances-index', 'AdminController@remittanceIndex');
    Route::post('admin/save-user', 'AdminController@saveUser');
    Route::post('admin/save-payment', 'AdminController@savePayment');
    Route::post('admin/ban', 'AdminController@ban');
    Route::post('admin/unban', 'AdminController@unban');
});


