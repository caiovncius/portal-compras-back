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

    Route::get('/functions', 'ProfileController@functions')
         ->name('functions');
    Route::get('/permissions', 'ProfileController@permissions')
         ->name('permissions');
    Route::get('/states', 'StateController@allStates')
         ->name('state.all');
    Route::get('/cities/by-state/{state}', 'CityController@allCities')
         ->name('cities.byState');

    Route::get('/users', 'UserController@list')
         ->name('user.list')
         ->middleware('acl:User,r,w');
    Route::get('/users/managers', 'UserController@managers')
         ->name('user.managers')
         ->middleware('acl:User,r');
    Route::get('/users/profile', 'UserController@profile')
         ->name('user.profile')
         ->middleware('acl:User,r');
    Route::post('/users/password', 'UserController@password')
         ->name('user.password')
         ->middleware('acl:User,r,w');
    Route::get('/users/{user}', 'UserController@get')
         ->name('user.get')
         ->middleware('acl:User,r');
    Route::get('/users/{user}/pharmacies/all', 'UserController@pharmaciesAll')
         ->name('user.pharmacies.all')
         ->middleware('acl:User,r');
    Route::get('/users/{user}/pharmacies', 'UserController@pharmacies')
         ->name('user.pharmacies')
         ->middleware('acl:User,r');
    Route::post('/users', 'UserController@store')
         ->name('user.store')
         ->middleware('acl:User,r,w');
    Route::put('/users/{user}', 'UserController@update')
         ->name('user.update')
         ->middleware('acl:User,r,w');
    Route::delete('/users/{user}', 'UserController@delete')
         ->name('user.delete')
         ->middleware('acl:User,r,w');

    Route::get('/profiles', 'ProfileController@list')
         ->name('profile.list')
         ->middleware('acl:Profile,r');
    Route::get('/profiles/{profile}', 'ProfileController@get')
         ->name('profile.get')
         ->middleware('acl:Profile,r');
    Route::get('/profiles/by-type/{type}', 'ProfileController@byType')
         ->name('profile.tpe')
         ->middleware('acl:Profile,r');
    Route::post('/profiles', 'ProfileController@store')
         ->name('profile.store')
         ->middleware('acl:Profile,r,w');
    Route::put('/profiles/{profile}', 'ProfileController@update')
         ->name('profile.update')
         ->middleware('acl:Profile,r,w');
    Route::delete('/profiles/{profile}', 'ProfileController@delete')
         ->name('profile.delete')
         ->middleware('acl:Profile,r,w');

    Route::get('/pharmacies', 'PharmacyController@list')
         ->name('pharmacy.list')
         ->middleware('acl:Pharmacy,r');
    Route::get('/pharmacies/{pharmacy}', 'PharmacyController@get')
         ->name('pharmacy.get')
         ->middleware('acl:Pharmacy,r');
    Route::post('/pharmacies', 'PharmacyController@store')
         ->name('pharmacy.store')
         ->middleware('acl:Pharmacy,r,w');
    Route::put('/pharmacies/{pharmacy}', 'PharmacyController@update')
         ->name('pharmacy.update')
         ->middleware('acl:Pharmacy,r,w');
    Route::delete('/pharmacies/{pharmacy}', 'PharmacyController@delete')
         ->name('pharmacy.delete')
         ->middleware('acl:Pharmacy,r,w');

    Route::get('/laboratories/active', 'LaboratoryController@active')
         ->name('laboratory.active')
         ->middleware('acl:Laboratory,r');
    Route::get('/laboratories', 'LaboratoryController@list')
         ->name('laboratory.list')
         ->middleware('acl:Laboratory,r');
    Route::get('/laboratories/{laboratory}', 'LaboratoryController@get')
         ->name('laboratory.get')
         ->middleware('acl:Laboratory,r');
    Route::post('/laboratories', 'LaboratoryController@store')
         ->name('laboratory.store')
         ->middleware('acl:Laboratory,r,w');
    Route::put('/laboratories/{laboratory}', 'LaboratoryController@update')
         ->name('laboratory.update')
         ->middleware('acl:Laboratory,r,w');
    Route::delete('/laboratories/{laboratory}', 'LaboratoryController@delete')
         ->name('laboratory.delete')
         ->middleware('acl:Laboratory,r,w');


    Route::get('/contacts', 'ContactController@list')
         ->name('contact.list')
         ->middleware('acl:Contact,r');
    Route::get('/contacts/{contact}', 'ContactController@get')
         ->name('contact.get')
         ->middleware('acl:Contact,r');
    Route::post('/contacts', 'ContactController@store')
         ->name('contact.store')
         ->middleware('acl:Contact,r,w');
    Route::put('/contacts/{contact}', 'ContactController@update')
         ->name('contact.update')
         ->middleware('acl:Contact,r,w');
    Route::delete('/contacts/{contact}', 'ContactController@delete')
         ->name('contact.delete')
         ->middleware('acl:Contact,r,w');

    Route::get('/distributors', 'DistributorController@list')
         ->name('distributor.list')
         ->middleware('acl:Distributor,r');
    Route::get('/distributors/all', 'DistributorController@all')
         ->name('distributor.all')
         ->middleware('acl:Distributor,r');
    Route::get('/distributors/{distributor}', 'DistributorController@get')
         ->name('distributor.get')
         ->middleware('acl:Distributor,r');
    Route::post('/distributors', 'DistributorController@store')
         ->name('distributor.store')
         ->middleware('acl:Distributor,r,w');
    Route::put('/distributors/{distributor}', 'DistributorController@update')
         ->name('distributor.update')
         ->middleware('acl:Distributor,r,w');
    Route::delete('/distributors/{distributor}', 'DistributorController@delete')
         ->name('distributor.delete')
         ->middleware('acl:Distributor,r,w');

    Route::get('/distributors/{distributor}/connection/test', 'DistributorConnectionController@test')
         ->name('distributor.connection.test')
         ->middleware('acl:Connection,r');
    Route::post('/distributors/{distributor}/connection', 'DistributorConnectionController@store')
         ->name('distributor.connection.store')
         ->middleware('acl:Connection,r,w');
    Route::put('/distributors/{distributor}/connection/{connection}', 'DistributorConnectionController@update')
         ->name('distributor.connection.update')
         ->middleware('acl:Connection,r,w');

    Route::get('/returns', 'ReturnsController@list')
         ->name('return.list')
         ->middleware('acl:Return,r');
    Route::get('/returns/{id}', 'ReturnsController@get')
         ->name('return.get')
         ->middleware('acl:Return,r');
    Route::post('/returns', 'ReturnsController@store')
         ->name('return.store')
         ->middleware('acl:Return,r,w');
    Route::put('/returns/{id}', 'ReturnsController@update')
         ->name('return.update')
         ->middleware('acl:Return,r,w');
    Route::delete('/returns/{id}', 'ReturnsController@delete')
         ->name('return.delete')
         ->middleware('acl:Return,r,w');

    Route::get('/programs', 'ProgramController@list')
         ->name('program.list')
         ->middleware('acl:Program,r');
    Route::get('/programs/{model}', 'ProgramController@get')
         ->name('program.get')
         ->middleware('acl:Program,r');
    Route::post('/programs', 'ProgramController@store')
         ->name('program.store')
         ->middleware('acl:Program,r,w');
    Route::put('/programs/{model}', 'ProgramController@update')
         ->name('program.update')
         ->middleware('acl:Program,r,w');
    Route::delete('/programs/{model}', 'ProgramController@delete')
         ->name('program.delete')
         ->middleware('acl:Program,r,w');

     Route::get('/programs/{model}/connection/test', 'ProgramConnectionController@test')
         ->name('program.connection.test')
         ->middleware('acl:Connection,r');
    Route::post('/programs/{model}/connection', 'ProgramConnectionController@store')
         ->name('program.connection.store')
         ->middleware('acl:Connection,r,w');
    Route::put('/programs/{model}/connection/{connection}', 'ProgramConnectionController@update')
         ->name('program.connection.update')
         ->middleware('acl:Connection,r,w');

    Route::get('/purchases', 'PurchaseController@list')
         ->name('purchase.list')
         ->middleware('acl:Purchase,r');
    Route::get('/purchases/{model}', 'PurchaseController@get')
         ->name('purchase.get')
         ->middleware('acl:Purchase,r');
    Route::post('/purchases', 'PurchaseController@store')
         ->name('purchase.store')
         ->middleware('acl:Purchase,r,w');
    Route::put('/purchases/{model}', 'PurchaseController@update')
         ->name('purchase.update')
         ->middleware('acl:Purchase,r,w');
    Route::delete('/purchases/{model}', 'PurchaseController@delete')
         ->name('purchase.delete')
         ->middleware('acl:Purchase,r,w');

    Route::get('/requests', 'RequestController@list')
         ->name('request.list')
         ->middleware('acl:Request,r');
    Route::get('/requests/{model}', 'RequestController@get')
         ->name('request.get')
         ->middleware('acl:Request,r');
    Route::post('/requests', 'RequestController@store')
         ->name('request.store')
         ->middleware('acl:Request,r,w');
    Route::put('/requests/{model}', 'RequestController@update')
         ->name('request.update')
         ->middleware('acl:Request,r,w');
    Route::delete('/requests/{model}', 'RequestController@delete')
         ->name('request.delete')
         ->middleware('acl:Request,r,w');

    Route::get('/purchases', 'PurchaseController@list')
         ->name('purchase.list')
         ->middleware('acl:Purchase,r');
    Route::get('/purchases/{model}', 'PurchaseController@get')
         ->name('purchase.get')
         ->middleware('acl:Purchase,r');
    Route::post('/purchases', 'PurchaseController@store')
         ->name('purchase.store')
         ->middleware('acl:Purchase,r,w');
    Route::put('/purchases/{model}', 'PurchaseController@update')
         ->name('purchase.update')
         ->middleware('acl:Purchase,r,w');
    Route::delete('/purchases/{model}', 'PurchaseController@delete')
         ->name('purchase.delete')
         ->middleware('acl:Purchase,r,w');

    Route::get('/requests', 'RequestController@list')
         ->name('request.list')
         ->middleware('acl:Request,r');
    Route::get('/requests/{model}', 'RequestController@get')
         ->name('request.get')
         ->middleware('acl:Request,r');
    Route::post('/requests', 'RequestController@store')
         ->name('request.store')
         ->middleware('acl:Request,r,w');
    Route::put('/requests/{model}', 'RequestController@update')
         ->name('request.update')
         ->middleware('acl:Request,r,w');
    Route::delete('/requests/{model}', 'RequestController@delete')
         ->name('request.delete')
         ->middleware('acl:Request,r,w');

    Route::get('/offers', 'OfferController@list')
         ->name('offer.list')
         ->middleware('acl:Offer,r');
    Route::get('/offers/{model}', 'OfferController@get')
         ->name('offer.get')
         ->middleware('acl:Offer,r');
    Route::post('/offers', 'OfferController@store')
         ->name('offer.store')
         ->middleware('acl:Offer,r,w');
    Route::put('/offers/{model}', 'OfferController@update')
         ->name('offer.update')
         ->middleware('acl:Offer,r,w');
    Route::delete('/offers/{model}', 'OfferController@delete')
         ->name('offer.delete')
         ->middleware('acl:Offer,r,w');
    Route::post('offer-products/{offer}', 'OfferProductController@store')
         ->name('offer.product.store')
         ->middleware('acl:Offer,r,w');

    Route::get('/products', 'ProductController@list')
         ->name('product.list')
         ->middleware('acl:Product,r');
    Route::get('/products/{product}', 'ProductController@get')
         ->name('product.get')
         ->middleware('acl:Product,r');
    Route::post('/products', 'ProductController@store')
         ->name('product.store')
         ->middleware('acl:Product,r,w');
    Route::put('/products/{product}', 'ProductController@update')
         ->name('product.update')
         ->middleware('acl:Product,r,w');
    Route::delete('/products/{product}', 'ProductController@delete')
         ->name('product.delete')
         ->middleware('acl:Product,r,w');

    Route::get('/conditions', 'ConditionController@list')
         ->name('condition.list')
         ->middleware('acl:Condition,r');
    Route::get('/conditions/{model}', 'ConditionController@get')
         ->name('condition.get')
         ->middleware('acl:Condition,r');
    Route::post('/conditions', 'ConditionController@store')
         ->name('condition.store')
         ->middleware('acl:Condition,r,w');
    Route::put('/conditions/{model}', 'ConditionController@update')
         ->name('condition.update')
         ->middleware('acl:Condition,r,w');
    Route::delete('/conditions/{model}', 'ConditionController@delete')
         ->name('condition.delete')
         ->middleware('acl:Condition,r,w');

    Route::get('/publicities', 'PublicityController@get')
         ->name('publicity.get')
         ->middleware('acl:Publicity,r');
    Route::put('/publicities', 'PublicityController@update')
         ->name('publicity.update')
         ->middleware('acl:Publicity,r,w');

    Route::get('/accompaniments', 'AccompanimentController@list')
         ->name('accompaniment.list')
         ->middleware('acl:Accompaniment,r');
    Route::get('/accompaniments/{model}', 'AccompanimentController@get')
         ->name('accompaniment.get')
         ->middleware('acl:Accompaniment,r');
    Route::post('/accompaniments', 'AccompanimentController@store')
         ->name('accompaniment.store')
         ->middleware('acl:Accompaniment,r,w');
    Route::put('/accompaniments/{model}', 'AccompanimentController@update')
         ->name('accompaniment.update')
         ->middleware('acl:Accompaniment,r,w');
    Route::delete('/accompaniments/{model}', 'AccompanimentController@delete')
         ->name('accompaniment.delete')
         ->middleware('acl:Accompaniment,r,w');
});
