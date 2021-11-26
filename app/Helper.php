<?php

namespace App;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;

class Helper
{

    public static function md5Verify($preStr, $sign, $key): bool
    {
        $preStr = $preStr . $key;

        if(md5($preStr) == $sign) {
            return true;
        }
        else {
            return false;
        }
    }

    public static function md5Sign($preStr, $key): string
    {
        return md5($preStr . $key);
    }

    public static function createLinkString($para)
    {
        $arg = "";
        foreach ($para as $key => $val) {
            $arg .= $key . "=" . $val . "&";
        }
        //去掉最后一个&字符
        $arg = substr($arg, 0, strlen($arg) - 1);

        return $arg;
    }

    public static function paraFilter($para): array
    {
        $para_filter = array();
        foreach ($para as $key => $val) {
            if ($key == "sign" || $key == "sign_type" || $val == "") continue;
            else    $para_filter[$key] = $val;
        }

        return $para_filter;
    }

    public static function argSort($para)
    {
        ksort($para);
        reset($para);
        return $para;
    }

    public static function randomNumber($length): string
    {
        $result = '';

        for ($i = 0; $i < $length; $i++) {
            $result .= mt_rand(0, 9);
        }

        return $result;
    }

    public static function site_1_config($key = null, $value = null)
    {
        $name = 'site1';

        if (! $config = Cache::get("admin.{$name}.config")) {
            $config = config('site1');
        }

        if (is_array($key)) {
            // 保存
            foreach ($key as $k => $v) {
                Arr::set($config, $k, $v);
            }

            Cache::put("admin.{$name}.config", $config);

            return;
        }

        if ($key === null) {
            return $config;
        }

        return Arr::get($config, $key, $value);
    }

}
