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

Route::middleware(['cors', 'auth:api'])->group(function(){

    Route::get('/functions', 'ProfileController@functions')->name('functions');
    Route::get('/states', 'StateController@allStates')->name('state.all');
    Route::get('/cities/by-state/{state}', 'CityController@allCities')->name('cities.byState');

    Route::get('/users', 'UserController@list')->name('user.list');
    Route::get('/users/managers', 'UserController@managers')->name('user.managers');
    Route::post('/users/password', 'UserController@password')->name('user.password');
    Route::get('/users/{user}', 'UserController@get')->name('user.get');
    Route::post('/users', 'UserController@store')->name('user.store');
    Route::put('/users/{user}', 'UserController@update')->name('user.update');
    Route::delete('/users/{user}', 'UserController@delete')->name('user.delete');

    Route::get('/profiles', 'ProfileController@list')->name('profile.list');
    Route::get('/profiles/{profile}', 'ProfileController@get')->name('profile.get');
    Route::get('/profiles/by-type/{type}', 'ProfileController@byType')->name('profile.tpe');
    Route::post('/profiles', 'ProfileController@store')->name('profile.store');
    Route::put('/profiles/{profile}', 'ProfileController@update')->name('profile.update');
    Route::delete('/profiles/{profile}', 'ProfileController@delete')->name('profile.delete');

    Route::get('/pharmacies', 'PharmacyController@list')->name('pharmacy.list');
    Route::get('/pharmacies/{pharmacy}', 'PharmacyController@get')->name('pharmacy.get');
    Route::post('/pharmacies', 'PharmacyController@store')->name('pharmacy.store');
    Route::put('/pharmacies/{pharmacy}', 'PharmacyController@update')->name('pharmacy.update');
    Route::delete('/pharmacies/{pharmacy}', 'PharmacyController@delete')->name('pharmacy.delete');

    Route::get('/laboratories/active', 'LaboratoryController@active')->name('laboratory.active');
    Route::get('/laboratories', 'LaboratoryController@list')->name('laboratory.list');
    Route::get('/laboratories/{laboratory}', 'LaboratoryController@get')->name('laboratory.get');
    Route::post('/laboratories', 'LaboratoryController@store')->name('laboratory.store');
    Route::put('/laboratories/{laboratory}', 'LaboratoryController@update')->name('laboratory.update');
    Route::delete('/laboratories/{laboratory}', 'LaboratoryController@delete')->name('laboratory.delete');


    Route::get('/contacts', 'ContactController@list')->name('contact.list');
    Route::get('/contacts/{contact}', 'ContactController@get')->name('contact.get');
    Route::post('/contacts', 'ContactController@store')->name('contact.store');
    Route::put('/contacts/{contact}', 'ContactController@update')->name('contact.update');
    Route::delete('/contacts/{contact}', 'ContactController@delete')->name('contact.delete');

    Route::get('/distributors', 'DistributorController@list')->name('distributor.list');
    Route::get('/distributors/all', 'DistributorController@all')->name('distributor.all');
    Route::get('/distributors/{distributor}', 'DistributorController@get')->name('distributor.get');
    Route::post('/distributors', 'DistributorController@store')->name('distributor.store');
    Route::put('/distributors/{distributor}', 'DistributorController@update')->name('distributor.update');
    Route::delete('/distributors/{distributor}', 'DistributorController@delete')->name('distributor.delete');

    Route::post('/distributors/{distributor}/connection', 'DistributorConnectionController@store')->name('distributor.connection.store');
    Route::put('/distributors/{distributor}/connection/{connection}', 'DistributorConnectionController@update')->name('distributor.connection.update');

    Route::get('/returns', 'ReturnsController@list')->name('return.list');
    Route::get('/returns/{id}', 'ReturnsController@get')->name('return.get');
    Route::post('/returns', 'ReturnsController@store')->name('return.store');
    Route::put('/returns/{id}', 'ReturnsController@update')->name('return.update');
    Route::delete('/returns/{id}', 'ReturnsController@delete')->name('return.delete');

    Route::get('/programs', 'ProgramController@list')->name('program.list');
    Route::get('/programs/{model}', 'ProgramController@get')->name('program.get');
    Route::post('/programs', 'ProgramController@store')->name('program.store');
    Route::put('/programs/{model}', 'ProgramController@update')->name('program.update');
    Route::delete('/programs/{model}', 'ProgramController@delete')->name('program.delete');

    Route::post('/programs/{model}/connection', 'ProgramConnectionController@store')->name('program.connection.store');
    Route::put('/programs/{model}/connection/{connection}', 'ProgramConnectionController@update')->name('program.connection.update');

    Route::get('/offers', 'OfferController@list')->name('offer.list');
    Route::get('/offers/{model}', 'OfferController@get')->name('offer.get');
    Route::post('/offers', 'OfferController@store')->name('offer.store');
    Route::put('/offers/{model}', 'OfferController@update')->name('offer.update');
    Route::delete('/offers/{model}', 'OfferController@delete')->name('offer.delete');

    Route::get('/products', 'ProductController@list')->name('product.list');
    Route::get('/products/{product}', 'ProductController@get')->name('product.get');
    Route::post('/products', 'ProductController@store')->name('product.store');
    Route::put('/products/{product}', 'ProductController@update')->name('product.update');
    Route::delete('/products/{product}', 'ProductController@delete')->name('product.delete');

    Route::get('/conditions', 'ConditionController@list')->name('condition.list');
    Route::get('/conditions/{model}', 'ConditionController@get')->name('condition.get');
    Route::post('/conditions', 'ConditionController@store')->name('condition.store');
    Route::put('/conditions/{model}', 'ConditionController@update')->name('condition.update');
    Route::delete('/conditions/{model}', 'ConditionController@delete')->name('condition.delete');

    Route::get('/publicities', 'PublicityController@list')->name('publicity.list');
    Route::get('/publicities/{model}', 'PublicityController@get')->name('publicity.get');
    Route::post('/publicities', 'PublicityController@store')->name('publicity.store');
    Route::post('/publicities/attach-image', 'PublicityController@attachImage')->name('publicity.attach.image');
    Route::put('/publicities/{model}', 'PublicityController@update')->name('publicity.update');
    Route::delete('/publicities/{model}', 'PublicityController@delete')->name('publicity.delete');
    Route::delete('/publicities/remove-image/{index}', 'PublicityController@removeImage')->name('publicity.remove.image');

    Route::get('/accompaniments', 'AccompanimentController@list')->name('accompaniment.list');
    Route::get('/accompaniments/{model}', 'AccompanimentController@get')->name('accompaniment.get');
    Route::post('/accompaniments', 'AccompanimentController@store')->name('accompaniment.store');
    Route::put('/accompaniments/{model}', 'AccompanimentController@update')->name('accompaniment.update');
    Route::delete('/accompaniments/{model}', 'AccompanimentController@delete')->name('accompaniment.delete');
});
