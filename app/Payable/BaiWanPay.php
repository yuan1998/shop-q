<?php

namespace App\Payable;

use App\Helper;
use App\Models\Order;
use App\Models\PayChannel;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;

class BaiWanPay extends FaCaiPay
{

    public static function getPayment($method)
    {
        $type = $method ?? 'alipay';
        if (!in_array($type, ['wechat', 'alipay'])) {
            $type = 'alipay';
        }
        return Helper::site_1_config("BaiWanPay.$type");
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

        $returnUrl = "{$domain}/#/checkout";
        $notifyUrl = "{$domain}/api/pay/notify/common?k=" . PayChannel::BaiWanPay;
        $data = [
            'merchantId' => $appid,
            'orderId' => static::generateOrderId($order->order_id),
            'orderAmount' => $order->price,
            'channelType' => $payment,
            'notifyUrl' => $notifyUrl,
            'returnUrl' => $returnUrl,
            'order_body' => Helper::site_1_config('order_name'),
        ];

        $data['sign'] = static::signStr($data, $appsecret, false);
//        $data['order_body'] = Helper::site_1_config('order_name');

//        dd($data);
        try {
            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => 'http://baiwan.2023fafa.shop/api/newOrder',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => $data,
            ));

            $body = curl_exec($curl);

            curl_close($curl);

            $a = json_decode($body, true);
            $code = data_get($a, 'code');
            if ($code == 200 && $url = data_get($a, 'data.payUrl')) {
                header("Location: $url");
                exit;
            }
            dd($body,$a,$data);
        } catch (GuzzleException $e) {
        }
    }


    public static function notify($payMethod = null, $request = null): string
    {
        $request = $request ?: request();
        $params = $request->all();
        $id = data_get($params, 'orderId', '');

        $orderData = explode('A', $id);
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

            return 'fail';
        }

        Log::info('notify回调测试 : $params', $params);

        if (data_get($params, 'status') == 'ok') {
            Log::info('notify回调测试 : $order', [
                $order
            ]);

            if ($order->status === Order::UN_PAY) {
                Log::info('支付成功;', []);
                $order->status = Order::PAY_SUCCESS;
                $order->pay_info = json_encode($params);
                $order->save();
                return 'ok';
            }
        }
        return 'fail';
    }

}
