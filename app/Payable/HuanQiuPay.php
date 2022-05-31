<?php

namespace App\Payable;

use App\Helper;
use App\Models\Order;
use App\Models\PayChannel;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;

class HuanQiuPay
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

        // 拼接 secret 然后MD5
        $str = Helper::md5Sign(strtoupper($preStr), strtoupper("&key=$key"));
        // 转换大写
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

        $isSgin = Helper::md5Verify(strtoupper($preStr), data_get($para_temp, 'sign'), strtoupper("&key={$payment->app_secret}"));

        Log::info('notify回调测试 : $verifyNotify', [
            '$isSgin' => $isSgin,
            '$para_temp' => $para_temp,
            'key' => $payment->app_secret
        ]);

        return $isSgin;
    }

    public static function payment($order, $payMethod, $request)
    {
        $appid = data_get($payMethod, 'app_key');//测试账户，
        $appsecret = data_get($payMethod, 'app_secret');//测试账户，

        $pay_type = Helper::site_1_config('wan_qiao_pay_code') ?? '305';
        $domain = $request->getSchemeAndHttpHost();

        $callback_url = $domain . '/api/pay/notify/huanQiuPay';
        $str = str_shuffle(time());

        $orderId = "{$order->order_id}A{$str}";
        $data = [
            'price' => $order->price,
            'order_id' => $orderId,
            'mark' => '1',
            'notify_url' => $callback_url,
            'app_id' => $appid,
            'time' => time(),
            'paytype' => $pay_type,
        ];

        $data['sign'] = static::signStr($data, $appsecret);

        $url = $payMethod->api_url ?: 'http://47.243.250.123:11888/Handler/sdk.ashx?type=create_neworder';

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

            if ($pay_url = data_get($result, 'Result.payurl')) {
                header("Location: $pay_url");
                exit;
            }
            dd($data, $result);

        } catch (GuzzleException $e) {
            echo "errcode:{$e->getCode()},errmsg:{$e->getMessage()}";
        }
    }

    public static function notify($payMethod = null, $request): string
    {
        $params = json_decode($request->get('return_type'));
        $orderData = explode('A', data_get($params, 'order_id', ''));
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
            if (data_get($params, 'msg') === '支付成功') {

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
