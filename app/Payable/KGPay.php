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
            'applydate' => now()->toDateTimeString(),
            'pay_amount' => round($order->price, 2) * 100,
            'pay_orderid' => $order->order_id,
        ];
        $data['pay_md5sign'] = static::signStr(array_merge($data, [
            'pay_notifyurl' => urlencode($notifyUrl),
            'pay_callbackurl' => urlencode($returnUrl),
        ]), $appsecret);
        $data['pay_productname'] = Helper::site_1_config('order_name');

        try {
            $client = new Client();
            $response = $client->request('post', "$payMethod->api_url/Pay_Index.html", [
                'form_params' => $data,
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
        }
    }


}
