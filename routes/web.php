<?php

use App\Http\Middleware\RestrictIpAddressMiddleware;
use App\Models\BlackList;
use Illuminate\Support\Facades\Log;
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

//Route::post('/','OrderController@orderNotifyFaCaiPay');

Route::group([
    'middleware' => [
        RestrictIpAddressMiddleware::class,
    ]
], function () {
    Route::get('/', 'WebController@index');
});


Route::get('/charge/success', 'WebController@chargeSuccess');

Route::get('/charge/checkout','WebController@chargeError');


Route::get('/whereismyip', 'WebController@whatIsMyIp');

Route::get('/clearmyblock', 'WebController@clearMyBlock');



Route::get('404','WebController@e404');
