<?php
namespace App\Http\Controllers;


use App\Http\Middleware\RestrictIpAddressMiddleware;
use App\Models\BlackList;

class WebController extends Controller {
    public function index() {
        if (\App\Admin\Actions\AccountLimit::isBlock())
            return '欠费';

        $setting = \App\Helper::site_1_config();
        $siteName = env('SITE_NAME', 'site1');
        return view($siteName, [
            'setting' => $setting,
        ]);
    }

    public function chargeSuccess() {
        return '充值成功';
    }
    public function chargeError() {
        return '未支付或支付失败';
    }
    public function whatIsMyIp() {
        $ip = request()->ip();
        $ipAddress = BlackList::config('ip');
        $block = $ipAddress->search($ip) === false ? '不在禁止名单' : '在禁止名单中';
        return "$ip : $block";
    }
    public function clearMyBlock() {
        RestrictIpAddressMiddleware::clearBlock();
        return '清除成功';
    }
    public function e404() {
        return view('404');
    }


}
