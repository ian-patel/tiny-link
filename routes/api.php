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

// Domain
Route::group(['prefix' => 'domain'], function () {
    Route::post('add', 'DomainController@store');
});

// Link
Route::group(['prefix' => 'link'], function () {
    Route::post('add', 'LinkController@store');
});
