<?php

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use Dcat\Admin\Admin;

Admin::routes();

Route::group([
    'prefix' => config('admin.route.prefix'),
    'namespace' => config('admin.route.namespace'),
    'middleware' => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/', 'HomeController@index');
    $router->group([
        'prefix' => 'charge_log'
    ], function (Router $router) {
        $router->get('charge', 'ChargeLogController@charge')->name('admin.account.limit.charge');

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
