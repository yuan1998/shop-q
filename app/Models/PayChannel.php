<?php

namespace App\Models;

//use Illuminate\Database\Eloquent\Model;

class PayChannel extends Model
{

    public static $pay_method = [
        'HU_PI_PAY' => '虎皮支付',
    ];

    public static function getPayMethod()
    {
        return static::query()
            ->select([
                'enable',
                'app_key',
                'app_secret'
            ])
            ->orderBy('enable', 'desc')
            ->first();
    }
}
