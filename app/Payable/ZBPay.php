<?php

namespace App\Payable;

use App\Helper;
use App\Models\Order;
use App\Models\PayChannel;
use App\TestOrder;
use Carbon\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ZBPay
{

    const AES = [
        '34h77jc9j2' => 'RF9MzOuIBafX6CyG'
    ];

    public static function getPayment($method)
    {
        $type = $method ?? 'alipay';
        if (!in_array($type, ['wechat', 'alipay'])) {
            $type = 'alipay';
        }
        return Helper::site_1_config("ZBPAY.$type");
    }


    public static function signStr($data, $key): string
    {
        //除去待签名参数数组中的空值和签名参数
        $para_filter = Helper::paraFilter($data);

        //对待签名参数数组排序
        $para_sort = Helper::argSort($para_filter);
        $preStr = Helper::createLinkString($para_sort);
        return Helper::md5Sign($preStr, "&key=$key");
    }

    public static function generateOrderId($order_id)
    {
        $str = Helper::generateStr(9);
        return "{$order_id}A{$str}";
    }

    public static function payment($order, $payMethod, $request)
    {
        $domain = $request->getHttpHost();

        $appid = data_get($payMethod, 'app_key');//测试账户，
        $appsecret = data_get($payMethod, 'app_secret');//测试账户，
        $aesCode = data_get(self::AES, $appid);

        $orderId = static::generateOrderId($order->order_id);

        $name = Helper::site_1_config('order_name');
        $code = static::getPayment($order->pay_method);

        Log::info('ZBPay 生产ID', [$orderId]);
        $data = [
            'channel' => $code,
            'mark' => $name,
            'price' => intval($order->price * 100),
            'orderNo' => $orderId,
            'returnType' => 'json',
            'notifyUrl' => "http://$domain/api/pay/notify/ZBPay",
            'returnUrl' => "http://$domain/api/pay/return",
        ];

        $data['sign'] = static::signStr($data, $appsecret);
        $dataStr = Helper::encryptAES(json_encode($data), $aesCode);


        try {
            $client = new Client();

            $response = $client->request('post', "https://sdspay.longlong.today/services/transcctionservice/api/payOrder/payment", [
                'json' => [
                    'data' => $dataStr,
                    'apiCode' => $appid
                ],
            ]);
            $body = $response->getBody()->getContents();

            preg_match("/(https?|http|ftp|file):\/\/[-A-Za-z0-9+&@#\/\%?=~_|!:,.;]+[-A-Za-z0-9+&@#\/\%=~_|]/", $body, $matches);
            $url = data_get($matches, 0);
            if ($url) {
                header("Location: $url");
                exit;
            }
            dd($body);

        } catch (GuzzleException $e) {
            dd($e->getMessage());
        }
    }


    public static function notify($payMethod = null, $request = null): string
    {
        $params = $request->all();
        Log::info('zb支付 : ', [$params]);
        if (!isset($params['apiCode']))
            return 'fail';

        $apiCode = data_get(self::AES, $params['apiCode']);

        $dataStr = Helper::decryptAES($params['data'], $apiCode);
        Log::info('zb支付 解码: ', [$dataStr]);

        $params = json_decode($dataStr, true);
        Log::info('zb支付 解码结果: ', [$params]);

        $orderData = explode('A', data_get($params, 'downstreamNo', ''));
        $id = data_get($orderData, '0');

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

        if ($params['status'] == '1') {
            $order->status = Order::PAY_SUCCESS;
            $order->pay_info = json_encode($params);
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
