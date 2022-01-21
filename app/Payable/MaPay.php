<?php

namespace App\Payable;

use App\Helper;
use App\Models\Order;
use App\Models\PayChannel;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;

class MaPay extends BSYiPay
{
    public static $apiUrl = 'http://vip3.fenxiaovip.cn/submit.php';

    public static function notify($payMethod = null, $request = null): string
    {
        $params = $request->all();
        $orderData = explode('A', data_get($params, 'payId', ''));
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
        $payMethod = $payMethod ?? $order->getPayment();

        $verifyNotify = static::verifyNotify($params, $payMethod);
        Log::info('notify回调测试 : $verifyNotify', [$verifyNotify]);

        if ($verifyNotify) {
            if (data_get($params, 'type') === '2') {
                if ($order->status === Order::UN_PAY) {
                    Log::info('支付成功;', []);
                    $order->status = Order::PAY_SUCCESS;
                    $order->pay_info = json_encode($params);
                    $order->save();
                    return 'success';
                }
            }
        }
        return 'failed';
    }

}
