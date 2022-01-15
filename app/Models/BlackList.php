<?php

namespace App\Models;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;

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

    public static function blockIp($value, $commit = '', $addType = self::ADD_TYPE_AUTO, $type = self::TYPE_IP)
    {
        if (!BlackList::query()->where('value', $value)->exists()) {
            BlackList::create([
                'value' => $value,
                'type' => $type,
                'add_type' => $addType,
                'remark' => $commit,
            ]);
        }
    }

    public static function getListByType($type)
    {
        $type = $type === 'ip' ? self::TYPE_IP : self::TYPE_PHONE;

        return static::query()
            ->select(['type', 'value'])
            ->where('type', $type)
            ->pluck('value')
            ->unique();
    }

    public static function setConfig($key)
    {
        if (!in_array($key, ['ip', 'phone'])) return null;
        $config = static::getListByType($key);
        static::config($key, $config);
    }

    public static function config($key, $value = null)
    {
        if (!in_array($key, ['ip', 'phone'])) return [];

        $name = "blackList.{$key}.config";
        if ($value) {
            Cache::put($name, $value);
        } else {
            if (!$config = Cache::get($name)) {
                $config = static::getListByType($key);
                Cache::put($name, $config);
            }

            return $config;
        }
    }

    public static function phoneIsBlock($phone)
    {
        $phoneList = static::config('phone');
        $result = $phoneList->search($phone) !== false;
        if ($result) {
            static::blockIp(request()->ip(), "通过{$phone}添加");
        }

        return $result;
    }

}
