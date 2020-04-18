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

Route::get('/all-product/{page}/{size}', 'Product\ProductController@index');

Route::get('/product/read/{id}', 'Product\ProductController@read');

//-------------------------------------------------------------------------------

Route::get('/order', 'Order\OrderController@index');

Route::get('/order/read/{id}', 'Order\OrderController@read');

Route::get('/order/order-product/{id}', 'Order\OrderController@getOrderProduct');

//-------------------------------------------------------------------------------

Route::get('/banner', 'Banner\BannerController@index');

Route::get('/banner/read/{id}', 'Banner\BannerController@read');

