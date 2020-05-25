<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware([])->group(function(){
    Route::get('/states', 'StateController@allStates')->name('state.all');
    Route::get('/cities/by-state/{state}', 'CityController@allCities')->name('cities.byState');

    Route::get('/users', 'UserController@list')->name('user.list');
    Route::post('/users', 'UserController@store')->name('user.store');
    Route::put('/users/{user}', 'UserController@update')->name('user.update');
    Route::delete('/users/{user}', 'UserController@delete')->name('user.delete');
});
