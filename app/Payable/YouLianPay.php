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
    public static $apiUrl = 'https://www.cshswl.top/submit.php';

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
        $para_sort = Helper::argSort($para_filter);
        $preStr = Helper::createLinkString($para_sort);

        return Helper::md5Sign($preStr, $key);
    }

    public static function createPay($data,$url = null)
    {
        $str = http_build_query($data);
        $url = $url ?: static::$apiUrl;
        $pay_url = "{$url}?{$str}";
        header("Location: $pay_url");
        exit;
    }

    public static function payment($order, $payMethod, $request)
    {
        $domain = $request->getSchemeAndHttpHost();;
        $appid = data_get($payMethod, 'app_key');//测试账户，
        $appsecret = data_get($payMethod, 'app_secret');//测试账户，

        $str = str_shuffle(time());

        $orderId = "{$order->order_id}A{$str}";

        $name = Helper::site_1_config('order_name');
        $data = [
            'money' => $order->price,
            'name' => $name,
            'notify_url' => $domain . '/api/pay/notify/yiPay',
            'out_trade_no' => $orderId,
            'pid' => $appid,
            'return_url' => $domain . '/api/pay/return',
            'sitename' => $name,
            'type' => static::getPayment($order->pay_method),
        ];
        $data['sign'] = static::signStr($data, $appsecret);
        $data['sign_type'] = 'MD5';

        static::createPay($data,data_get($payMethod , 'api_url'));
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
        $orderData = explode('A', data_get($params, 'out_trade_no', ''));
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

        if ($orderData) {
            $verifyNotify = static::verifyNotify($params, $payMethod);

            if ($verifyNotify) {
                if (data_get($params, 'trade_status') === 'TRADE_SUCCESS') {
                    $order = Order::query()
                        ->where('order_id', $id)
                        ->first();
                    Log::info('notify回调测试 : $order', [
                        $order
                    ]);

                    if ($order && $order->status === Order::UN_PAY) {
                        Log::info('支付成功;', []);
                        $order->status = Order::PAY_SUCCESS;
                        $order->pay_info = json_encode($params);
                        $order->save();
                        return 'success';
                    }
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
