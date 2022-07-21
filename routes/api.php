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
    Route::post('outPay', 'OrderController@outPay');
    Route::post('store', 'OrderController@store');
    Route::post('store/products', 'OrderController@storeProducts');
    Route::get('list', 'OrderController@orderList');
    Route::get('getById', 'OrderController@orderById');
    Route::get('searchByPhone', 'OrderController@getPhoneOrderList');
    Route::post('return/request', 'OrderController@requestReturn');
    Route::post('return/shipReturn', 'OrderController@shipReturnProduct');
    Route::post('return/cancel', 'OrderController@cancelReturn');
});

Route::group([
    'prefix' => 'banner'
], function () {
    Route::get('list', 'BannerController@list');
});

Route::group([
    'prefix' => 'complaint'
], function () {
    Route::post('store', 'ComplaintController@store');
});

Route::group([
    'prefix' => 'product'
], function () {
    Route::get('detail', 'ProductController@detail');
    Route::get('list', 'ProductController@list');
    Route::get('replies', 'ProductController@productReplies');
});

Route::group([
    'prefix' => 'pay'
], function () {
    Route::get('/', 'OrderController@orderPay');
    Route::any('notify', 'OrderController@orderNotify');
    Route::any('notify/hupi', 'OrderController@orderNotifyHupi');
    Route::any('notify/yiPay', 'OrderController@orderNotifyYiPay');
    Route::any('notify/youLianPay', 'OrderController@orderNotifyYouLianPay');
    Route::any('notify/faCaiPay', 'OrderController@orderNotifyFaCaiPay');
    Route::any('notify/wanQiaoPay', 'OrderController@orderNotifyWanQiaoPay');
    Route::any('notify/huanQiuPay', 'OrderController@orderNotifyHuanQiuPay');
    Route::any('notify/baXiPay', 'OrderController@orderNotifyBaXiPay');
    Route::any('notify/k11Pay', 'OrderController@orderNotifyK11Pay');
    Route::any('notify/yiMeiPay', 'OrderController@orderNotifyYiMeiPay');
    Route::any('return', 'OrderController@orderReturn');
    Route::any('return/faCaiPay', 'OrderController@orderReturnFaCaiPay');
});

Route::group([
    'prefix' => 'setting'
], function () {
    Route::get('/', function () {
        return response()
            ->json(\App\Helper::site_1_config());
    });
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
