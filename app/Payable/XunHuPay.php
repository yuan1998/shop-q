<?php
namespace App\Payable;

use App\Helper;

class XunHuPay extends HuPiPay {
    public static function networkUrl()
    {
        return Helper::site_1_config('xunhu_api_2') ?? 'https://api.xunhupay.com/payment/do.html';
    }
}
