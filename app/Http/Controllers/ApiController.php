<?php
namespace App\Http\Controllers;


use App\Http\Middleware\RestrictIpAddressMiddleware;
use App\Models\BlackList;

class ApiController extends Controller {
    public function setting() {
        return response()
            ->json(\App\Helper::site_1_config());
    }
    public function test() {
        \App\Models\Product::fixProductImageToSuperBed();
    }
}
