<?php

namespace App\Payable;

use App\Helper;
use App\Models\Order;
use App\Models\PayChannel;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;

class FaCaiPay
{
    public static $apiUrl = 'https://www.facai1688.shop:8081/way/pay_index.html';

    public static $payment = [
        "IOS" => [
            'wechat' => '808',
            'alipay' => '911',
        ],
        "ANDROID" => [
            'wechat' => '808',
            'alipay' => '909',
        ]
    ];

    public static function getPayment($method)
    {
        $userAgent = $_SERVER['HTTP_USER_AGENT'];
        $device = (strstr($userAgent,'iPhone') || strstr($userAgent,'iPad') )? 'IOS' : 'ANDROID';

        $type = $method ?? 'alipay';
        if (!in_array($type, array_keys(static::$payment))) {
            $type = 'alipay';
        }
        return data_get(static::$payment, "$device.$type");
    }

    public static function signStr($data, $key): string
    {
        //除去待签名参数数组中的空值和签名参数
        $para_filter = Helper::paraFilter($data);

        //对待签名参数数组排序
        $para_sort = Helper::argSort($para_filter);
        $preStr = Helper::createLinkString($para_sort);

        $str = Helper::md5Sign($preStr, "&key=$key");
        $str = strtoupper($str);
        return $str;
    }

    public static function payment($order, $payMethod, $request)
    {
        $payment = static::getPayment($order->pay_method);

        $domain = $request->getSchemeAndHttpHost();
        $appid = data_get($payMethod, 'app_key');//测试账户，
        $appsecret = data_get($payMethod, 'app_secret');//测试账户，


        $returnUrl = $domain . '/api/pay/return/faCaiPay';
        $notifyUrl = $domain . '/api/pay/notify/faCaiPay';
        $data = [
            'pay_bankcode' => $payment,
            'pay_memberid' => $appid,
            'pay_amount' => round($order->price, 2) * 100,
//            'pay_productname' =>  Helper::site_1_config('order_name'),
            'pay_notifyurl' => $notifyUrl,
            'pay_returnurl' => $returnUrl,
            'pay_orderid' => $order->order_id,
        ];
        $data['pay_md5sign'] = static::signStr(array_merge($data, [
            'pay_notifyurl' => urlencode($notifyUrl),
            'pay_returnurl' => urlencode($returnUrl),
        ]), $appsecret);
        $query = http_build_query($data);

        try {

            $url = $payMethod->api_url ?: static::$apiUrl;
            header("Location: $url?$query");
            exit;

        } catch (\GuzzleHttp\Exception\GuzzleException $e) {
            echo "errcode:{$e->getCode()},errmsg:{$e->getMessage()}";
        }

    }

    public static function verifyNotify($para_temp, $payment): bool
    {
        //除去待签名参数数组中的空值和签名参数
        $para_filter = Helper::paraFilter($para_temp);

        //对待签名参数数组排序
        $para_sort = Helper::argSort($para_filter);

        //把数组所有元素，按照“参数=参数值”的模式用“&”字符拼接成字符串
        $preStr = Helper::createLinkString($para_sort);
        $isSgin = Helper::md5Verify($preStr, strtolower(data_get($para_temp, 'sign')), $payment->app_secret);

        Log::info('notify回调测试 : $verifyNotify', [
            '$isSgin' => $isSgin,
        ]);

        return $isSgin;
    }

    public static function notify($payMethod = null, $request = null): string
    {
        $params = $request->all();
        $id = data_get($params, 'orderid', '');
        Log::info('notify回调测试 : $id', [
            'id' => $id
        ]);
        $order = Order::query()
            ->where('order_id', $id)
            ->first();

        if (!$order) {
            Log::info('notify 测试: 订单不存在', [
                $params
            ]);

            return 'fail';
        }

        Log::info('notify回调测试 : $params', $params);
        $payMethod = $payMethod ?? $order->getPayment();

        if (static::verifyNotify($params, $payMethod)) {
            if (data_get($params, 'returncode') === '00') {
                Log::info('notify回调测试 : $order', [
                    $order
                ]);

                if ($order->status === Order::UN_PAY) {
                    Log::info('支付成功;', []);
                    $order->status = Order::PAY_SUCCESS;
                    $order->pay_info = json_encode($params);
                    $order->save();
                    return 'success';
                }
            }
        }
        return 'fail';
    }

    public static function handleReturn($request)
    {
        $params = $request->all();
        $domain = $request->getSchemeAndHttpHost();

        Log::info('return回调测试 : $params', $params);
        if (data_get($params, 'returncode') === '00') {
            header("Location: {$domain}/#/success");
            exit;
        }

        header("Location: {$domain}/#/checkout");
        exit;
    }

}
