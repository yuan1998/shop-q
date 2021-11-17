<?php

namespace App\Models;

class Complaint extends Model
{
    protected $fillable = [
        'phone',
        'comment',
        'wechat',
        'order_id'
    ];


}
