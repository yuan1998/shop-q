<?php

namespace App\Models;

use Dcat\Admin\Traits\HasDateTimeFormatter;
use Illuminate\Database\Eloquent\Model;

class ChargeLog extends Model
{
    use HasDateTimeFormatter;
    protected $fillable = [
        'uuid',
        'price',
        'status',
        'notify_date'
    ];

    const STATUS_UNPAY = 0;
    const STATUS_PAYMENT = 1;

    const STATUS_LIST  =[
        self::STATUS_UNPAY => '未支付',
        self::STATUS_PAYMENT => '已支付',
    ];

}
