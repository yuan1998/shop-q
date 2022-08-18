<?php

namespace App;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;

class Helper
{

    public static function md5Verify($preStr, $sign, $key): bool
    {
        $preStr = $preStr . $key;

        if (md5($preStr) == $sign) {
            return true;
        } else {
            return false;
        }
    }

    public static function md5Sign($preStr, $key): string
    {
        $str = $preStr . $key;
        return md5($str);
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

    public static function site_1_config($key = null, $value = null, $name = null)
    {
        $name = $name ?: env('SITE_NAME', 'site1');

        if (!$config = Cache::get("admin.{$name}.config")) {
            $config = config($name);
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

    public static function encryptAES($data, $key)
    {
        return base64_encode(openssl_encrypt($data, 'aes-128-ecb', $key, OPENSSL_PKCS1_PADDING));//OPENSSL_PKCS1_PADDING 不知道为什么可以与PKCS5通用,未深究
    }


    /**
     * 可以解密java等的aes/ecb/pcks5加密的内容
     * @param $data
     * @param $key
     * @author Farmer
     */
    public static function decryptAES($data, $key)
    {
        return openssl_decrypt(base64_decode($data), 'aes-128-ecb', $key, OPENSSL_PKCS1_PADDING);//OPENSSL_PKCS1_PADDING 不知道为什么可以与PKCS5通用,未深究
    }

    public static function generateStr($length)
    {
        $token = "";
        $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $codeAlphabet .= "abcdefghijklmnopqrstuvwxyz";
        $codeAlphabet .= "0123456789";
        $max = strlen($codeAlphabet); // edited

        for ($i = 0; $i < $length; $i++) {
            $token .= $codeAlphabet[self::crypto_rand_secure(0, $max - 1)];
        }

        return $token;
    }

    public static  function crypto_rand_secure($min, $max)
    {
        $range = $max - $min;
        if ($range < 1) return $min; // not so random...
        $log = ceil(log($range, 2));
        $bytes = (int) ($log / 8) + 1; // length in bytes
        $bits = (int) $log + 1; // length in bits
        $filter = (int) (1 << $bits) - 1; // set all lower bits to 1
        do {
            $rnd = hexdec(bin2hex(openssl_random_pseudo_bytes($bytes)));
            $rnd = $rnd & $filter; // discard irrelevant bits
        } while ($rnd > $range);
        return $min + $rnd;
    }

}
