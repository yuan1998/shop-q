<?php

namespace App\Payable;

use App\Models\Order;
use App\Models\PayChannel;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;

class ChangLianPay
{
    public static $payment = [
        'wechat' => 'partnerH5',
        'alipay' => 'shengH5',
    ];

    public static function getPayment($method)
    {
        $type = $method ?? 'wechat';
        if (!in_array($type, array_keys(static::$payment))) {
            $type = 'wechat';
        }
        return data_get(static::$payment, $type);
    }


    public static function getSign($secret, $data)
    {
        // 去空
        $data = array_filter($data);
        //签名步骤一：按字典序排序参数
        ksort($data);
        if ($data['pay_type'] == 'AliRoyalty') {
            foreach ($data['royalty_parameters'] as $k => $v) {
                ksort($data['royalty_parameters'][$k]);
            }
        }
        // var_dump($data);
        $string_a = http_build_query($data);
        $string_a = urldecode($string_a);

        //签名步骤二：在string后加入mch_key
        $string_sign_temp = $string_a . "&key=" . $secret;
        // var_dump($string_sign_temp);
        //签名步骤三：MD5加密
        $sign = md5($string_sign_temp);

        // 签名步骤四：所有字符转为大写
        $result = strtoupper($sign);
        // var_dump($result);
        return $result;
    }

    /**
     * @Note   验证签名
     * @param $data
     * @param $orderStatus
     * @return bool
     */
    public static function verifySign($data, $secret)
    {
        // 验证参数中是否有签名
        if (!isset($data['sign']) || !$data['sign']) {
            return false;
        }
        // 要验证的签名串
        $sign = $data['sign'];
        unset($data['sign']);
        // 生成新的签名、验证传过来的签名
        $sign2 = getSign($secret, $data);

        return $sign2;
    }

    public static function payment($order, $payMethod, $request)
    {
        $appid = data_get($payMethod, 'app_key');//测试账户，
        $appsecret = data_get($payMethod, 'app_secret');//测试账户，

        $pay_type = static::getPayment($order->pay_method);
        $domain = env('APP_URL');
        $success_url = $domain . '/#success';
        $error_url = $domain . '/#checkout';
        $callback_url = $domain . '/api/pay/notify';
        $version = 'v1.0';
        $extend = json_encode([
            'body' => '耐克球鞋'
        ]);

        $str = str_shuffle(time());

        $orderId = "{$order->order_id}A{$str}";

        $data = [
            'appid' => $appid,
            'pay_type' => $pay_type,
            'out_trade_no' => $orderId,
            'amount' => number_format((float)$order->price, 2, '.', ''),
            'callback_url' => $callback_url,
            'success_url' => $success_url,
            'error_url' => $error_url,
            'version' => $version,
            'extend' => $extend,
        ];


        $data['sign'] = static::getSign($appsecret, $data);

        /**
         * 个人支付宝/微信官方支付，支付网关：https://api.xunhupay.com
         * 微信支付宝代收款，需提现，支付网关：https://pay.wordpressopen.com
         */
        $url = 'https://api2.payunk.com/index/unifiedorder?format=json';

        try {
            Log::info('payment 测试 $data' ,[
                $data
            ]);
            $client = new Client();
            $response = $client->post($url, [
                'form_params' => $data,
            ]);
            $result = $response->getBody()->getContents();

            $result = json_decode($result, true);
            Log::info('payment 测试 $result' ,[
            $result
                ]);


            $pay_url = $result['url'];
            header("Location: $pay_url");
            exit;
        } catch (GuzzleException $e) {
            echo "errcode:{$e->getCode()},errmsg:{$e->getMessage()}";

        }
    }

    public static function notify($payMethod, $request): string
    {

//        $appid = data_get($payMethod, 'app_key', env('HU_PI_PAY_APP_KEY'));//测试账户，
        $appsecret = data_get($payMethod, 'app_secret');//测试账户，

        $data = $request->all();
        Log::info('notify 测试 $data', $data);
        if (data_get($data, 'appid') !== data_get($payMethod, 'app_key')) {
            exit('error:appid');
        }

        $params = [
            'appid' => data_get($data, 'appid'),
            'callbacks' => data_get($data, 'callbacks'),
            'pay_type' => data_get($data, 'pay_type'),
            'amount' => data_get($data, 'amount'),
            'success_url' => data_get($data, 'success_url'),
            'error_url' => data_get($data, 'error_url'),
            'out_trade_no' => data_get($data, 'out_trade_no'),
            'sign' => data_get($data, 'sign'),
        ];
        $signV =  static::verifySign($params, $appsecret);
        Log::info('notify 测试 $signV', [
            $signV
        ]);
        if (data_get($data, 'sign') == $signV) {
            if (data_get($data, 'callbacks') === 'CODE_SUCCESS') {
                $orderData = explode('A', data_get($params, 'out_trade_no', ''));

                $id = data_get($orderData, '0');
                Log::info('notify 测试 $id', [
                    $id
                ]);

                $order = Order::query()
                    ->where('order_id', $id)
                    ->first();

                if ($order->status != Order::PAY_SUCCESS) {
                    $order->status = Order::PAY_SUCCESS;
                    $order->pay_info = json_encode($data);
                    $order->save();
                }
            }
        } else {
            exit('error:sign');
        }

        return 'success';

    }
}
