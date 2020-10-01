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

Route::get('/return/offer', '\App\Services\RequestOffer@check');
Route::get('/return/purchase', '\App\Services\RequestPurchase@check');
Route::get('purchase', '\App\Services\PurchaseCheck@check');
