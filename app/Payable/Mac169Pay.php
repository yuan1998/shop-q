<?php
namespace App\Payable;

use App\Helper;

class Mac169Pay extends HuPiPay {
    public static function networkUrl()
    {
        return Helper::site_1_config('mac169_api') ?? 'https://api.mac169.com/payment/do.html';
    }
}
