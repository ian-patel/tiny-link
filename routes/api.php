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
| Auto middleware auth:api
|
*/

// User
Route::group(['prefix' => 'user'], function () {
    Route::get('/', function (Request $request) {
        return $request->user();
    });
});

// Auth
Route::group(['prefix' => 'auth'], function () {
    Route::post('logout', 'Auth\LoginController@logout');
});

// Domain
Route::group(['prefix' => 'domains'], function () {
    Route::post('add', 'DomainController@store');
});

// Link
Route::group(['prefix' => 'links'], function () {
    Route::get('/', 'LinkController@index');
    Route::get('dig', 'LinkController@dig');
    Route::post('add', 'LinkController@store');
});
