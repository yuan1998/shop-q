<?php

namespace App\Http\Controllers;

use App\Models\Order;
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

        $appid = env('HU_PI_PAY_APP_KEY');//测试账户，
        $appsecret = env('HU_PI_PAY_APP_SECRET');//测试账户，
        $my_plugin_id = env('HU_PI_PAY_APP_PLUGIN');
//        $appid              = '201906120002';//测试账户，
//        $appsecret          = '7a0967a8f830c9319c87e01e691b8f09';//测试账户，
        $domain = env('APP_URL');

        $data = array(
            'version' => '1.1',//固定值，api 版本，目前暂时是1.1
            'lang' => 'zh-cn', //必须的，zh-cn或en-us 或其他，根据语言显示页面
            'plugins' => $my_plugin_id,//必须的，根据自己需要自定义插件ID，唯一的，匹配[a-zA-Z\d\-_]+
            'appid' => $appid, //必须的，APPID
            'trade_order_id' => $order->order_id, //必须的，网站订单ID，唯一的，匹配[a-zA-Z\d\-_]+
            'payment' => $request->get('payment', 'wechat'),//必须的，支付接口标识：wechat(微信接口)|alipay(支付宝接口)
            'type' => 'WAP',//固定值"WAP" H5支付必填
            'wap_url' => env('HU_PI_PAY_HOME_URL'),//网站域名，H5支付必填
            'wap_name' => env('HU_PI_PAY_HOME_NAME'),//网站域名，或者名字，必填，长度32或以内 H5支付必填
            'total_fee' => $order->price, //人民币，单位精确到分(测试账户只支持0.1元内付款)
            'title' => '耐克球鞋', //必须的，订单标题，长度32或以内
            'time' => time(),//必须的，当前时间戳，根据此字段判断订单请求是否已超时，防止第三方攻击服务器
            'notify_url' => $domain . '/api/pay/notify', //必须的，支付成功异步回调接口
            'return_url' => $domain . '/#success',//必须的，支付成功后的跳转地址
            'callback_url' => $domain . '/#checkout',//必须的，支付发起地址（未支付或支付失败，系统会会跳到这个地址让用户修改支付信息）
            'modal' => null, //可空，支付模式 ，可选值( full:返回完整的支付网页; qrcode:返回二维码; 空值:返回支付跳转链接)
            'nonce_str' => str_shuffle(time())//必须的，随机字符串，作用：1.避免服务器缓存，2.防止安全密钥被猜测出来
        );
        $hashkey = $appsecret;

        $data['hash'] = HuPiPay::generate_xh_hash($data, $hashkey);

        /**
         * 个人支付宝/微信官方支付，支付网关：https://api.xunhupay.com
         * 微信支付宝代收款，需提现，支付网关：https://pay.wordpressopen.com
         */
        $url = 'https://api.diypc.com.cn/payment/do.html';

        try {
            $response = HuPiPay::http_post($url, json_encode($data));

            /**
             * 支付回调数据
             * @var array(
             *      order_id, //支付系统订单ID
             *      url //支付跳转地址
             *  )
             */
            $result = $response ? json_decode($response, true) : null;


            if (!$result) {
                throw new \Exception('Internal server error', 500);
            }

            $hash = HuPiPay::generate_xh_hash($result, $hashkey);
            if (!isset($result['hash']) || $hash != $result['hash']) {
                throw new \Exception('Invalid sign!', 40029);
            }

            if ($result['errcode'] != 0) {
                throw new \Exception($result['errmsg'], $result['errcode']);
            }


            $pay_url = $result['url'];
            header("Location: $pay_url");
            exit;
        } catch (\Exception $e) {
            echo "errcode:{$e->getCode()},errmsg:{$e->getMessage()}";
            //TODO:处理支付调用异常的情况
        }
    }

    public function orderNotify(Request $request)
    {
        $appsecret = env('HU_PI_PAY_APP_SECRET');//测试账户，
        $my_plugin_id = env('HU_PI_PAY_APP_PLUGIN');

        $data = $request->post();
        Log::info('notify 测试', $data);

        foreach ($data as $k => $v) {
            $data[$k] = stripslashes($v);
        }

        if (!isset($data['hash']) || !isset($data['trade_order_id'])) {
            Log::info('参数不存在');
            return 'failed';
        }

        //自定义插件ID,请与支付请求时一致
        if (isset($data['plugins']) && $data['plugins'] != $my_plugin_id) {
            Log::info('自定义插件ID,请与支付请求时一致');
            return 'failed';
        }

        //APP SECRET

        $hash = HuPiPay::generate_xh_hash($data, $appsecret);
        if ($data['hash'] != $hash) {
            Log::info('签名验证失败');
            //签名验证失败
            return 'failed';
        }

        //商户订单ID
        $trade_order_id = $data['trade_order_id'];

        $order = Order::query()
            ->where('order_id', $trade_order_id)
            ->first();


        if ($data['status'] == 'OD') {
            if ($order->status != Order::PAY_SUCCESS) {
                $order->status = Order::PAY_SUCCESS;
                $order->pay_info = json_encode($data);
                $order->save();
            }

        } else {
            if ($order->status != Order::PAY_ERROR) {
                $order->status = Order::PAY_ERROR;
                $order->pay_info = json_encode($data);
                $order->save();
            }
        }


//以下是处理成功后输出，当支付平台接收到此消息后，将不再重复回调当前接口
        return 'success';
    }
}
