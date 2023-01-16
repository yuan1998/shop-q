<?php

namespace App\Payable;

use App\Helper;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class KGPay extends FaCaiPay
{


    public static function getPayment($method)
    {
        $type = $method ?? 'alipay';
        if (!in_array($type, ['wechat', 'alipay'])) {
            $type = 'alipay';
        }
        return Helper::site_1_config("KGPAY.$type");
    }

    public static function generateOrderId($order_id)
    {
        $str = Helper::generateStr(4);
        return "{$order_id}A{$str}";
    }

    public static function payment($order, $payMethod, $request)
    {
        $payment = static::getPayment($order->pay_method);
        if (!$payment)
            throw new \Exception('没有配置支付通道!!');

        $domain = $request->getSchemeAndHttpHost();
        $appid = data_get($payMethod, 'app_key');//测试账户，
        $appsecret = data_get($payMethod, 'app_secret');//测试账户，

        $returnUrl = "{$domain}/api/pay/return/faCaiPay";
        $notifyUrl = "{$domain}/api/pay/notify/faCaiPay";
        $data = [
            'pay_bankcode' => $payment,
            'pay_memberid' => $appid,
            'pay_applydate' => now()->toDateTimeString(),
            'pay_amount' => $order->price,
            'pay_orderid' => static::generateOrderId($order->order_id),
            'pay_notifyurl' => $notifyUrl,
            'pay_callbackurl' => $returnUrl,
        ];

        $data['pay_md5sign'] = static::signStr($data, $appsecret);
        $data['pay_productname'] = Helper::site_1_config('order_name');

        try {
            $client = new Client();
            $api_url = $payMethod->api_url;
            if (!$api_url)
                throw new \Exception('没有配置支付网关!!');

            $response = $client->request('post', "$api_url/Pay_Index.html", [
                'form_params' => $data,
            ]);
            $body = $response->getBody()->getContents();
            $a = json_decode($body, true);
            $code = data_get($a, 'code');
            if ($code === 200 && $url = data_get($a, 'data')) {
                header("Location: $url");
                exit;
            }
            dd($body,$a);
        } catch (GuzzleException $e) {
        }
    }


}
