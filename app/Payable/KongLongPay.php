<?php

namespace App\Payable;

use App\Helper;
use App\Models\Order;
use App\Models\PayChannel;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;

class KongLongPay extends FaCaiPay
{

    public static function getPayment($method)
    {
        $type = $method ?? 'alipay';
        if (!in_array($type, ['wechat', 'alipay'])) {
            $type = 'alipay';
        }
        return Helper::site_1_config("KongLongPAY.$type");
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
        $notifyUrl = "{$domain}/api/pay/notify/common?k=" . PayChannel::KongLongPay;
        $data = [
            'mchid' => $appid,
            'out_trade_no' => static::generateOrderId($order->order_id),
            'amount' => $order->price,
            'channel' => $payment,
            'return_url' => $returnUrl,
            'notify_url' => $notifyUrl,
            'body' => Helper::site_1_config('order_name'),
            'time_stamp' => now()->format("Ymdhis00"),
        ];

        $data['sign'] = static::signStr($data, $appsecret,false);
//        dd($data);
        try {
            $client = new Client();
            $api_url = $payMethod->api_url ?: "http://konglong.zhifuwx.com/";
            if (!$api_url)
                throw new \Exception('没有配置支付网关!!');

            $response = $client->request('post', "$api_url/api/pay/unifiedorder", [
                'form_params' => $data,
            ]);
            $body = $response->getBody()->getContents();
            $a = json_decode($body, true);
            $code = data_get($a, 'code');
            if ($code === 0 && $url = data_get($a, 'data.request_url')) {
                header("Location: $url");
                exit;
            }
            dd($body);
        } catch (GuzzleException $e) {
        }
    }


    public static function notify($payMethod = null, $request = null): string
    {
        $request = $request ?: request();
        if (!$request->has(["memberid", "orderid", "amount", "datetime", "transaction_id", "returncode"]))
            Log::info('notify 测试: 返回数据不对');
        $params = $request->all();
        $id = data_get($params, 'out_trade_no', '');

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

        if (data_get($params, 'order_status') === '1') {
            Log::info('notify回调测试 : $order', [
                $order
            ]);

            if ($order->status === Order::UN_PAY) {
                Log::info('支付成功;', []);
                $order->status = Order::PAY_SUCCESS;
                $order->pay_info = json_encode($params);
                $order->save();
                return 'OK';
            }
        }
        return 'fail';
    }

}
