<?php

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Dcat\Admin\Admin;

Admin::routes();

Route::group([
    'prefix' => config('admin.route.prefix'),
    'namespace' => config('admin.route.namespace'),
    'middleware' => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('limit/view' , 'LimitController@index');
    $router->post('limit/action' , 'LimitController@action')->name('admin.limit.action');

    $router->get('/', 'HomeController@index');
    $router->get('/rate', 'HomeController@rate');

    Route::get('/charge', function () {
        $url = env('QR_CODE_URL');
        if(!$url) return '充值未开放';
        return view('pay.qrcode',[
            'url' => $url
        ]);
    })->name('admin.account.charge.view');

    $router->group([
        'prefix' => 'charge_log'
    ], function (Router $router) {
        $router->post('charge', 'ChargeLogController@charge')->name('admin.account.limit.charge');
    });

    $router->resource('charge_logs', 'ChargeLogController');
    $router->resource('attributes', 'AttributeController');
    $router->resource('categories', 'CategoryController');
    $router->resource('products', 'ProductController');
    $router->resource('orders', 'OrderController');
    $router->resource('pay_channel', 'PayChannelController');
    $router->resource('complaint', 'ComplaintController');
    $router->resource('product_reply', 'ProductReplyController');
    $router->resource('banners', 'BannerController');
    $router->resource('black_list', 'BlackListController');
});
