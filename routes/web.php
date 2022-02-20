<?php

use App\Http\Middleware\RestrictIpAddressMiddleware;
use App\Models\BlackList;
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

Route::post('/','OrderController@orderNotifyFaCaiPay');

Route::group([
    'middleware' => [
        RestrictIpAddressMiddleware::class,
    ]
], function () {
    Route::get('/', function () {
        $setting = \App\Helper::site_1_config();
        $siteName = env('SITE_NAME', 'site1');
        return view($siteName, [
            'setting' => $setting,
        ]);
    });
});


Route::get('/whereismyip', function () {
    $ip = request()->ip();
    $ipAddress = BlackList::config('ip');
    $block = $ipAddress->search($ip) === false ? '不在禁止名单' : '在禁止名单中';
    return "$ip : $block";
});

Route::get('/clearmyblock', function () {
    RestrictIpAddressMiddleware::clearBlock();
    return '清除成功';
});

Route::get('404', function () {
    return view('404');
});

Route::group([
    'prefix' => 'pay'
], function () {
    Route::get('success', function () {
        $data = request()->all();
        dd('success', $data);
    });
    Route::get('checkout', function () {
        $data = request()->all();
        dd('checkout', $data);
    });
});

