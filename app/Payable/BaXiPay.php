<?php

namespace App\Payable;

use App\Helper;
use App\Models\Order;
use App\Models\PayChannel;
use App\TestOrder;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class BaXiPay
{
    public static $apiUrl = 'http://pay.speedlycp.com/pay/recharge/order';

    public static $payment = [
        'wechat' => 'wxpay',
        'alipay' => 'alipay',
        'qqpay' => 'qqpay',
        'tenpay' => 'tenpay',
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
//        $para_sort = Helper::argSort($para_filter);
        $preStr = Helper::createLinkString($para_filter);
        return Helper::md5Sign($preStr, "&key=$key");
    }

    public static function createPay($data, $url = null)
    {
        $str = http_build_query($data);
        $url = $url ?: static::$apiUrl;
        $pay_url = "{$url}?{$str}";
        header("Location: $pay_url");
        exit;
    }

    public static function generateOrderId($order_id)
    {
        $str = str_shuffle(time());
        return "{$order_id}A{$str}";
    }

    public static function payment($request)
    {
        $domain = $request->getSchemeAndHttpHost();
        // $appid = data_get($payMethod, 'app_key');//测试账户，
        $appid = 10002;
//        $appsecret = data_get($payMethod, 'app_secret');//测试账户，
        $appsecret = '94b86d2bc94e6765ff085fe76c1c38e7';

        $price = $request->get('amount', 1);

        $order = TestOrder::create([
            'amount' => $price,
            'merchantId' => $appid,
        ]);

        $data = [
            'payType' => 101,
            'merchantId' => $appid,
            'amount' => $price,
            'orderId' => $order->id,
            'notifyUrl' => $domain . '/api/pay/notify/baXiPay',
        ];
        $data['sign'] = static::signStr($data, $appsecret);


        try {
            $client = new Client();
            $response = $client->request('post', "http://pay.speedlycp.com/pay/recharge/order", [
                'json' => $data,
            ]);
            $body = $response->getBody()->getContents();
            $result = json_decode($body, true);
            $url = data_get($result, 'data.payUrl');
            if ($url) {
                header("Location: $url");
                exit;
            }
            dd($data, $result);
        } catch (GuzzleException $e) {
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

    public static function notify($request = null): string
    {
        $params = $request->all();
        Log::info('巴西支付 : ', [$params]);
        $id = $request->get('orderId');

        $order = TestOrder::find($id);

        if (!$order) {
            Log::info('notify 测试: 订单不存在', [
                $params
            ]);

            return 'failed';
        }


        if ($request->get('orderStatus') === 1) {
            $order->orderStatus = 1;
            $order->save();
            return 'SUCCESS';
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
