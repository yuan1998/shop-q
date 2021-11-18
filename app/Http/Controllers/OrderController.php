<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\PayChannel;
use App\Payable\HuPiPay;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->only(['product_id', 'product_sku', 'custom_info', 'count', 'price']);

        try {
            $order = Order::generateOrder($data);
        } catch (\Exception $exception) {
            $msg = $exception->getMessage();
            return response()
                ->json([
                    'status' => 1,
                    'errMsg' => $msg,
                ])
                ->setStatusCode(400);
        }

        return response()
            ->json([
                'status' => 0,
                'id' => $order->order_id,
                'msg' => '创建订单成功!'
            ]);
    }

    public function outPay(Request $request): \Illuminate\Http\JsonResponse
    {
        $orderId = $request->get('order_id');
        $model = Order::query()
            ->where('order_id', $orderId)
            ->first();

        if ($model->status != Order::PAY_SUCCESS) {
            return response()
                ->json([
                    'status' => 1,
                    'errMsg' => '当前订单不支持退款,可能未支付或者已退款.',
                ]);
        }

        $model->status = Order::PAY_OUTING;
        $model->save();

        return response()
            ->json([
                'status' => 0,
                'msg' => '订单开始退款,请耐心等待'
            ]);
    }

    public function orderList(Request $request): \Illuminate\Http\JsonResponse
    {
        $orderId = $request->get('order_id');
        $list = Order::query()
            ->whereIn('order_id', explode(',', $orderId))
            ->orderBy('id', 'desc')
            ->paginate(10);

        return response()
            ->json([
                'status' => 0,
                'data' => $list,
                'msg' => '获取订单成功!'
            ]);
    }

    public function orderPay(Request $request)
    {
        $id = $request->get('order_id');
        if (!$id || !($order = Order::query()->where('order_id', $id)->first())) {
            echo '订单不存在,请刷新页面';
            return;
        }

        $payMethod = PayChannel::getPayMethod();
        if (!$payMethod)
            throw new \Exception('未配置支付渠道.');

        return $payMethod->payment($order, $request);

    }

    public function orderNotify(Request $request)
    {
        $payMethod = PayChannel::getPayMethod();
        if (!$payMethod)
            throw new \Exception('未配置支付渠道.');

        return $payMethod->notify($request);
    }

    public function orderReturn(Request $request)
    {
        $payMethod = PayChannel::getPayMethod();
        if (!$payMethod)
            throw new \Exception('未配置支付渠道.');

        return $payMethod->handleReturn($request);
    }
}
