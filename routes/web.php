<?php

use App\Supports\VuexInitialState;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// })->name('login');

Route::group(['namespace' => 'Auth'], function () {
    // Login
    Route::group(['prefix' => 'login'], function () {
        Route::get('{provider}', 'LoginController@redirectToProvider');
        Route::get('{provider}/callback', 'LoginController@handleProviderCallback');

        // Test login
        Route::get('user/{user}', 'LoginController@testLogin');
    });
});

Route::get('/login', function () {
    return view('welcome', ['initialState' => VuexInitialState::session()]);
})->name('login');

// Vue routes
Route::get('/{vue?}', function () {
    return view('welcome', ['initialState' => VuexInitialState::session()]);
})->where('vue', '[\/\w\.-]*')->middleware('auth:api');
