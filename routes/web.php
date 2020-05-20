<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return response()->make('API status ok');
});

Route::middleware([])->group(function(){
    Route::get('/states', 'StateController@allStates')->name('state.all');
    Route::get('/cities/by-state/{state}', 'CityController@allCities')->name('cities.byState');
});

