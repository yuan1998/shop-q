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

    $router->resource('attributes', 'AttributeController');
    $router->resource('categories', 'CategoryController');
    $router->resource('products', 'ProductController');
    $router->resource('orders', 'OrderController');
    $router->resource('pay_channel', 'PayChannelController');
    $router->resource('complaint', 'ComplaintController');
    $router->resource('product_reply', 'ProductReplyController');
});
