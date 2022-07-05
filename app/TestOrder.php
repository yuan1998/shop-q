<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TestOrder extends Model
{
    protected $fillable = [
        'merchantId',
        'amount',
        'remark',
        'orderStatus',
    ];
}
