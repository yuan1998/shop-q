<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderReturn extends Model
{
    const RETURN_REQUEST = 1;
    const RETURN_AGREE_WAIT_SHIP = 2;
    const RETURN_AGREE_SHIP = 3;
    const ONLY_RETURN_REQUEST = 4;
    const ONLY_RETURN_AGREE = 5;
    const ONLY_RETURN_DISAGREE = 6;
    const EXCHANGE_REQUEST = 7;
    const EXCHANGE_REQUEST_WAIT_SHIP = 8;
    const EXCHANGE_REQUEST_SHIP = 9;

    public static $outStatus = [
        self::RETURN_REQUEST => '退货退款申请',
        self::RETURN_AGREE_WAIT_SHIP => '退货退款同意-待发货',
        self::RETURN_AGREE_SHIP => '退货退款同意-已发货',
        self::EXCHANGE_REQUEST => '换货/换款',
        self::EXCHANGE_REQUEST_WAIT_SHIP => '同意换货/换款-待发货',
        self::EXCHANGE_REQUEST_SHIP => '同意换货/换款-已发货',
        self::ONLY_RETURN_REQUEST => '退款申请',
        self::ONLY_RETURN_AGREE => '同意退款',
        self::ONLY_RETURN_DISAGREE => '取消退款',
    ];

}
