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
    $setting = \App\Helper::site_1_config();
    $siteName = env('SITE_NAME' ,'site1');
    return view($siteName, [
        'setting' => $setting,
    ]);
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

