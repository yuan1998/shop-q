<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderReturn;
use App\Models\PayChannel;
use App\Payable\BaXiPay;
use App\Payable\BSYiPay;
use App\Payable\FaCaiPay;
use App\Payable\HuanQiuPay;
use App\Payable\HuPiPay;
use App\Payable\K11Pay;
use App\Payable\WanQiaoPay;
use App\Payable\YiMeiPay;
use App\Payable\YouLianPay;
use App\Payable\ZBPay;
use Carbon\Carbon;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->only([
            'product_id',
            'product_sku',
            'custom_info',
            'count',
            'price',
            'payment',
        ]);

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

    public function storeProducts(Request $request)
    {
        $data = $request->only([
            'product',
            'custom_info',
            'payment',
        ]);

        try {
            $order = Order::generateProductsOrder($data);
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

    public function orderById(Request $request): \Illuminate\Http\JsonResponse
    {
        $orderId = $request->get('order_id');
        $item = Order::query()
            ->where('order_id', $orderId)
            ->first();

        return response()
            ->json([
                'status' => 0,
                'data' => $item,
                'msg' => '获取订单成功!'
            ]);
    }

    public function requestReturn(Request $request): \Illuminate\Http\JsonResponse
    {
        $orderId = $request->get('order_id');
        if (!($order = Order::query()->where('order_id', $orderId)->first())) {
            return response()->json([
                'status' => 1,
                'errMsg' => '错误的订单号,请确认订单号'
            ]);
        }

        $returnReason = $request->get('return_reason');
        $returnStatus = $request->get('return_status');
        $order->return_status = $returnStatus;
        $order->status = Order::PAY_OUTING;
        $order->return_at = Carbon::now()->toDateTimeString();
        $order->return_reason = $returnReason;
        $order->save();

        return response()
            ->json([
                'status' => 0,
                'msg' => '退款申请成功,请等待审核',
            ]);
    }

    public function shipReturnProduct(Request $request): \Illuminate\Http\JsonResponse
    {
        $orderId = $request->get('order_id');
        if (!($order = Order::query()->where('order_id', $orderId)->first())) {
            return response()->json([
                'status' => 1,
                'errMsg' => '错误的订单号,请确认订单号'
            ]);
        }
        $returnStatus = $request->get('return_status');
        $logistics = $request->get('logistics');
        $order->return_logistics_number = $logistics;
        $order->return_status = $returnStatus;
        $order->save();

        return response()
            ->json([
                'status' => 0,
                'msg' => '提交成功,请耐心等待',
            ]);
    }

    public function cancelReturn(Request $request): \Illuminate\Http\JsonResponse
    {
        $orderId = $request->get('order_id');
        if (!($order = Order::query()->where('order_id', $orderId)->first())) {
            return response()->json([
                'status' => 1,
                'errMsg' => '错误的订单号,请确认订单号'
            ]);
        }
        $order->return_status = OrderReturn::ONLY_RETURN_DISAGREE;
        $order->save();

        return response()
            ->json([
                'status' => 0,
                'msg' => '提交成功!',
            ]);
    }

    public function getPhoneOrderList(Request $request): \Illuminate\Http\JsonResponse
    {
        $phone = $request->get('phone');
        $data = [];

        if ($phone) {
            $data = Order::query()
                ->select([
                    'custom_info',
                    'order_id',
                ])
                ->where('custom_info', 'like', "%$phone%")
                ->get()
                ->pluck('order_id');
        }

        return response()
            ->json([
                'status' => 0,
                'data' => $data,
                'msg' => '查询成功'
            ]);
    }

    public function orderPay(Request $request)
    {
        $id = $request->get('order_id');
        if (!$id || !($order = Order::query()->where('order_id', $id)->first())) {
            echo '订单不存在,请刷新页面';
            return;
        }

        $payMethod = $order->getPayment();

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

    public function orderNotifyHupi(Request $request): string
    {
        return HuPiPay::notify(null, $request);
    }

    public function orderNotifyYiPay(Request $request): string
    {
        return BSYiPay::notify(null, $request);
    }

    public function orderNotifyYouLianPay(Request $request): string
    {
        return YouLianPay::notify(null, $request);
    }

    public function orderNotifyFaCaiPay(Request $request): string
    {
        return FaCaiPay::notify(null, $request);
    }

    public function orderNotifyWanQiaoPay(Request $request)
    {
        WanQiaoPay::notify(null, $request);
    }

    public function orderNotifyHuanQiuPay(Request $request)
    {
        HuanQiuPay::notify(null, $request);
    }

    public function orderNotifyBaXiPay(Request $request)
    {
        BaXiPay::notify($request);
    }

    public function orderNotifyK11Pay(Request $request)
    {
        K11Pay::notify($request);
    }

    public function orderNotifyYiMeiPay(Request $request)
    {
        YiMeiPay::notify(null, $request);
    }

    public function orderNotifyZBPay(Request $request)
    {
        return ZBPay::notify(null, $request);
    }

    public function orderReturn(Request $request)
    {
        BSYiPay::handleReturn($request);
    }

    public function orderReturnFaCaiPay(Request $request)
    {
        FaCaiPay::handleReturn($request);
    }


}
