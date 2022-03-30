<?php

namespace App\Payable;

use App\Helper;
use App\Models\Order;
use App\Models\PayChannel;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;

class WanQiaoPay
{
    public static $payment = [
        'wechat' => 'partnerH5',
        'alipay' => 'shengH5',
    ];

    public static function getPayment($method)
    {
        $type = $method ?? 'wechat';
        if (!in_array($type, array_keys(static::$payment))) {
            $type = 'wechat';
        }
        return data_get(static::$payment, $type);
    }

    public static function signStr($data, $key): string
    {
        //除去待签名参数数组中的空值和签名参数
        $para_filter = Helper::paraFilter($data);

        //对待签名参数数组排序
        $para_sort = Helper::argSort($para_filter);
        $preStr = Helper::createLinkString($para_sort);

        $str = Helper::md5Sign($preStr, "$key");
//        $str = strtoupper($str);
        return $str;
    }

    public static function verifyNotify($para_temp, $payment): bool
    {
        //除去待签名参数数组中的空值和签名参数
        $para_filter = Helper::paraFilter($para_temp);

        //对待签名参数数组排序
        $para_sort = Helper::argSort($para_filter);

        //把数组所有元素，按照“参数=参数值”的模式用“&”字符拼接成字符串
        $preStr = Helper::createLinkString($para_sort);
        $isSgin = Helper::md5Verify($preStr, data_get($para_temp, 'sign'), $payment->app_secret);

        Log::info('notify回调测试 : $verifyNotify', [
            '$isSgin' => $isSgin,
            '$para_temp' =>$para_temp,
            'key' =>$payment->app_secret
        ]);

        return $isSgin;
    }

    public static function payment($order, $payMethod, $request)
    {
        $appid = data_get($payMethod, 'app_key');//测试账户，
        $appsecret = data_get($payMethod, 'app_secret');//测试账户，

//        $pay_type = static::getPayment($order->pay_method);
        $pay_type = Helper::site_1_config('wan_qiao_pay_code') ?? '1661';
        $domain = $request->getSchemeAndHttpHost();
        $success_url = $domain . '/#success';
        $callback_url = $domain . '/api/pay/notify/wanQiaoPay';
        $str = str_shuffle(time());

        $orderId = "{$order->order_id}A{$str}";
        $data = [
            'order_sn' => $orderId,
            'money' => $order->price,
            'notify_url' => $callback_url,
            'success_url' => $success_url,
            'member_id' => $appid,
            'channel' => $pay_type,
        ];

        $data['sign'] = static::signStr($data, $appsecret);

        $data['return_type'] = 1;
        $data['param'] = 1;

        /**
         * 个人支付宝/微信官方支付，支付网关：https://api.xunhupay.com
         * 微信支付宝代收款，需提现，支付网关：https://pay.wordpressopen.com
         */
        $url = $payMethod->api_url ?: 'http://www.wanqiaokejikj.com/unifiedorder/zf/pay';

        try {
            Log::info('payment 测试 $data', [
                $data
            ]);
            $client = new Client();
            $response = $client->post($url, [
                'form_params' => $data,
                'verify' => false,
            ]);
            $result = $response->getBody()->getContents();

            $result = json_decode($result, true);

            Log::info('payment 测试 $result', [
                $result
            ]);

            if ($result['code'] === '0') {
                $pay_url = data_get($result, 'data.url');
                header("Location: $pay_url");
                exit;
            }
            dd($result);

        } catch (GuzzleException $e) {
            echo "errcode:{$e->getCode()},errmsg:{$e->getMessage()}";
        }
    }

    public static function notify($payMethod = null, $request): string
    {
        $params = $request->all();
        $orderData = explode('A', data_get($params, 'order_sn', ''));
        $id = data_get($orderData, '0');
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

            return 'failed';
        }

        Log::info('notify回调测试 : $params', $params);
        Log::info('notify回调测试 : $orderData', $orderData);
        $payMethod = $payMethod ?? $order->getPayment();

        if (static::verifyNotify($params, $payMethod)) {
            if (data_get($params, 'status') === '10001') {

                if ($order->status != Order::PAY_SUCCESS) {
                    $order->status = Order::PAY_SUCCESS;
                    $order->pay_info = json_encode($params);
                    $order->save();
                }
            }
            return 'success';
        }


        return 'failed';

    }
}
