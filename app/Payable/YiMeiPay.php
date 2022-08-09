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

class YiMeiPay
{
    const ID_LIST = [
        '1142' => 'a270552f35484c0ab8f5f7710137aea1',
    ];

    public static function getPayment($method)
    {
        $type = $method ?? 'alipay';
        if (!in_array($type, ['wechat', 'alipay'])) {
            $type = 'alipay';
        }
        return Helper::site_1_config("亿美.$type");
    }


    public static function signStr($data, $key): string
    {
        //除去待签名参数数组中的空值和签名参数
        $para_filter = Helper::paraFilter($data);

        //对待签名参数数组排序
        $para_sort = Helper::argSort($para_filter);
        $preStr = Helper::createLinkString($para_sort);
        return strtoupper(Helper::md5Sign($preStr, "$key"));
    }

    public static function generateOrderId($order_id)
    {
        $str = str_shuffle(time());
        return "{$order_id}A{$str}";
    }

    public static function payment($order, $payMethod, $request)
    {
        $domain = $request->getSchemeAndHttpHost();

        $appid = data_get($payMethod, 'app_key');//测试账户，
        $appsecret = data_get($payMethod, 'app_secret');//测试账户，
        if (!$appsecret) {
            $appid = '1142';
            $appsecret = 'a270552f35484c0ab8f5f7710137aea1';
        }
        $orderId = static::generateOrderId($order->order_id);

        $name = Helper::site_1_config('order_name');
        $code = static::getPayment($order->pay_method);

        $data = [
            'mch_id' => $appid,
            'pass_code' => $code,
            'subject' => $name,
            'amount' => $order->price,
            'out_trade_no' => $orderId,
            'client_ip' => mt_rand(0, 255) . "." . mt_rand(0, 255) . "." . mt_rand(0, 255) . "." . mt_rand(0, 255),
            'timestamp' => Carbon::now()->toDateTimeString(),
            'notify_url' => $domain . '/api/pay/notify/yiMeiPay',
            'return_url' => $domain . '/api/pay/return',
        ];
        $data['sign'] = static::signStr($data, $appsecret);

        $requestDomain = Helper::site_1_config('亿美.api_domain', 'http://134.122.193.169:8888');

        try {
            $client = new Client();

            $response = $client->request('post', "$requestDomain/api/unifiedorder", [
                'json' => $data,
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


    public static function notify($payMethod = null, $request = null): string
    {
        $params = $request->all();
        Log::info('yi mei支付 : ', [$params]);
        $orderData = explode('A', data_get($params, 'out_trade_no', ''));
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

        if ($request->get('status') == '2') {
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
