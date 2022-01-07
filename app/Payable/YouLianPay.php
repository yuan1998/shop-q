<?php

namespace App\Payable;

use App\Helper;
use App\Models\Order;
use App\Models\PayChannel;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;

class YouLianPay
{
    public static $apiUrl = 'http://api.kjiax.com/payapi/pay/jspay3';

    public static $payment = [
        'wechat' => 'comm.mini.url',
        'alipay' => 'alipay.comm.qrcode',
    ];

    public static function getPayment($method)
    {
        $type = $method ?? 'alipay';
        if (!in_array($type, array_keys(static::$payment))) {
            $type = 'alipay';
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

        return Helper::md5Sign($preStr, "&signkey=$key");
    }

    public static function createPay($data, $url = null)
    {
        $str = http_build_query($data);
        $url = $url ?: static::$apiUrl;
        $pay_url = "{$url}?{$str}";
        header("Location: $pay_url");
        exit;
    }

    public static function getPaymentApi($pay)
    {
        return $pay === 'comm.mini.url' ? 'http://api.kjiax.com/payapi/mini/mini_url' : 'http://api.kjiax.com/payapi/pay/qrcode';
    }

    public static function getPaymentParams($order,$payMethod) {


    }

    public static function payment($order, $payMethod, $request)
    {
        $payment = static::getPayment($order->pay_method);
        $domain = $request->getSchemeAndHttpHost();
        $appid = data_get($payMethod, 'app_key');//测试账户，
        $appsecret = data_get($payMethod, 'app_secret');//测试账户，

        $str = str_shuffle(time());

        $orderId = "{$order->order_id}";

        $data = [
            'service' => $payment,
            'apikey' => $appid,
            'money' => $order->price,
            'nonce_str' => $str,
            'url_link' => '1',
            'notify_url' =>  $domain . '/api/pay/notify/youLianPay',
            'mch_orderid' => $orderId,
        ];
        $data['sign'] = static::signStr($data, $appsecret);
        $apiUrl = static::getPaymentApi($payment);

        try {
            $client = new Client();
            $response = $client->request('post', $apiUrl, [
                'form_params' => $data,
            ]);
            $body = $response->getBody()->getContents();
            $responseData = json_decode($body, true);
            $pay_url = data_get($responseData,  $payment === 'comm.mini.url' ? 'url' : 'qr_code');

            if ($pay_url) {
                header("Location: $pay_url");
                exit;
            }
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
        $isSgin = Helper::md5Verify($preStr, data_get($para_temp, 'sign'), $payment->app_secret);

        Log::info('notify回调测试 : $verifyNotify', [
            '$isSgin' => $isSgin,
        ]);

        return $isSgin;
    }

    public static function notify($payMethod = null, $request = null): string
    {
        $params = $request->all();
        $id = data_get($params, 'trade_no', '');
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
            if (data_get($params, 'paystatus') != '2') {
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
        if (data_get($params, 'trade_status') === 'TRADE_SUCCESS') {
            header("Location: {$domain}/#/success");
            exit;
        }

        header("Location: {$domain}/#/checkout");
        exit;
    }

}
