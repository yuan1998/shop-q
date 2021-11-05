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

Route::group([
    'prefix' => 'order'
], function () {
    Route::post('store', 'OrderController@store');
});

Route::group([
    'prefix' => 'pay'
], function () {
    Route::get('/', 'OrderController@orderPay');
    Route::post('notify', 'OrderController@orderNotify');
});


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
