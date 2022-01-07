<?php

namespace App\Models;

class BlackList extends Model
{
    protected $fillable = [
        'add_type',
        'type',
        'value',
        'remark',
    ];

    const ADD_TYPE_AUTO = 0;
    const ADD_TYPE_MANUAL = 1;
    public static $addTypeList = [
        self::ADD_TYPE_AUTO => '自动添加',
        self::ADD_TYPE_MANUAL => '手动添加',
    ];

    const TYPE_IP = 0;
    const TYPE_PHONE = 1;
    public static $typeList = [
        self::TYPE_IP => 'IP',
        self::TYPE_PHONE => '电话'
    ];

}
