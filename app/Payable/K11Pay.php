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

class K11Pay
{
    const ID_LIST = [
        '10176' => 'buz06711l5rtc5jjz8it9ba026mdntfa',
        '10055' => 'zqwbg0s35ihpr2qdysb4ao5l1ca7b3uv',
    ];

    public static function signStr($data, $key): string
    {
        //除去待签名参数数组中的空值和签名参数
        $para_filter = Helper::paraFilter($data);

        //对待签名参数数组排序
        $para_sort = Helper::argSort($para_filter);
        $preStr = Helper::createLinkString($para_sort);
        return strtoupper(Helper::md5Sign($preStr, "&key=$key"));
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
        $appid = $request->get('merchantId', 10055);
//        $appsecret = data_get($payMethod, 'app_secret');//测试账户，
        $appsecret = data_get(self::ID_LIST, $appid);
        if (!$appsecret) {
            $appid = '10055';
            $appsecret = 'zqwbg0s35ihpr2qdysb4ao5l1ca7b3uv';
        }


        $price = $request->get('amount', 1);

        $order = TestOrder::create([
            'amount' => $price,
            'merchantId' => $appid,
        ]);

        $id = static::generateOrderId($order->id);

        $data = [
            'pay_memberid' => $appid,
            'pay_amount' => $price,
            'pay_orderid' => $id,
            'pay_applydate' => Carbon::now()->toDateTimeString(),
            'pay_notifyurl' => $domain . '/api/pay/notify/k11Pay',
            'pay_callbackurl' => $domain . '/test_pay/return',
        ];
        $data['pay_md5sign'] = static::signStr($data, $appsecret);
        $data['pay_productname'] = 'phone';
        $data['pay_attach'] = 'phone';


        try {
            $client = new Client();
            $response = $client->request('post', "https://k11pay.com/Pay_Index.html", [
                'form_params' => $data,
            ]);
            $body = $response->getBody()->getContents();
            preg_match("/(https?|http|ftp|file):\/\/[-A-Za-z0-9+&@#\/\%?=~_|!:,.;]+[-A-Za-z0-9+&@#\/\%=~_|]/",$body , $matches);
            $url = data_get($matches,0);
            if ($url) {
                header("Location: $url");
                exit;
            }
            dd($body);

        } catch (GuzzleException $e) {
        }
    }


    public static function notify($request = null): string
    {
        $params = $request->all();
        Log::info('k11支付 : ', [$params]);
        $orderData = explode('A', data_get($params, 'out_trade_no', ''));
        $id = data_get($orderData, '0');

        $id = $request->get('orderid');

        $order = TestOrder::find($id);

        if (!$order) {
            Log::info('notify 测试: 订单不存在', [
                $params
            ]);

            return 'failed';
        }


        if ($request->get('returncode') == '00') {
            $order->orderStatus = 1;
            $order->save();
            return 'OK';
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
