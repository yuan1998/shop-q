<?php

namespace App\Payable;

use App\Helper;
use App\Models\Order;
use App\Models\PayChannel;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use function Psy\debug;

class HuPiPay
{
    public static function http_post($url, $data)
    {
        if (!function_exists('curl_init')) {
            throw new \Exception('php未安装curl组件', 500);
        }

        $protocol = (!empty ($_SERVER ['HTTPS']) && $_SERVER ['HTTPS'] !== 'off' || $_SERVER ['SERVER_PORT'] == 443) ? "https://" : "http://";
        $siteurl = $protocol . $_SERVER['HTTP_HOST'];
        $proxy = env('PROXY_HOST', '');
        $proxyPort = env('PROXY_PROT', '');

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_REFERER, $siteurl);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_PROXY, $proxy);
        curl_setopt($ch, CURLOPT_PROXYPORT, $proxyPort);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_2_0);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $response = curl_exec($ch);
        $httpStatusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);
        if ($httpStatusCode != 200) {
            throw new \Exception("invalid httpstatus:{$httpStatusCode} ,response:$response,detail_error:" . $error, $httpStatusCode);
        }

        return $response;
    }

    public static function retry_http($url, $data, $count = 10)
    {
        $result = null;
        do {
            try {
                Log::info('debug 请求支付:开始请求', ['url' => $url]);
                $response = HuPiPay::http_post($url, json_encode($data));
                $result = $response ? json_decode($response, true) : null;
            } catch (\Exception $e) {
            }
            if (!$result) {
                sleep(2);
            }
            $count--;
        } while (!($result || $count <= 0));

        return $result;
    }

    public static function isWebApp()
    {
        if (!isset($_SERVER['HTTP_USER_AGENT'])) {
            return false;
        }

        $u = strtolower($_SERVER['HTTP_USER_AGENT']);
        if ($u == null || strlen($u) == 0) {
            return false;
        }

        preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/', $u, $res);

        if ($res && count($res) > 0) {
            return true;
        }

        if (strlen($u) < 4) {
            return false;
        }

        preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/', substr($u, 0, 4), $res);
        if ($res && count($res) > 0) {
            return true;
        }

        $ipadchar = "/(ipad|ipad2)/i";
        preg_match($ipadchar, $u, $res);
        return $res && count($res) > 0;
    }

    public static function generate_xh_hash(array $datas, $hashkey)
    {
        ksort($datas);
        reset($datas);

        $pre = array();
        foreach ($datas as $key => $data) {
            if (is_null($data) || $data === '') {
                continue;
            }
            if ($key == 'hash') {
                continue;
            }
            $pre[$key] = stripslashes($data);
        }

        $arg = '';
        $qty = count($pre);
        $index = 0;

        foreach ($pre as $key => $val) {
            $arg .= "$key=$val";
            if ($index++ < ($qty - 1)) {
                $arg .= "&";
            }
        }

        return md5($arg . $hashkey);
    }

    public static function is_wechat_app()
    {
        return strripos($_SERVER['HTTP_USER_AGENT'], 'micromessenger');
    }

    public static function networkUrl()
    {
        return Helper::site_1_config('xunhu_api') ?? 'https://api.diypc.com.cn/payment/do.html';
    }

    public static function payment($order, $payMethod, $request)
    {
        $appid = data_get($payMethod, 'app_key', env('HU_PI_PAY_APP_KEY'));//测试账户，
        $appsecret = data_get($payMethod, 'app_secret', env('HU_PI_PAY_APP_SECRET'));//测试账户，
//        $appsecret = env('HU_PI_PAY_APP_SECRET');//测试账户，
        $my_plugin_id = env('HU_PI_PAY_APP_PLUGIN');
//        $appid              = '201906120002';//测试账户，
//        $appsecret          = '7a0967a8f830c9319c87e01e691b8f09';//测试账户，
        $domain = $request->getSchemeAndHttpHost();

        $data = array(
            'version' => '1.1',//固定值，api 版本，目前暂时是1.1
            'lang' => 'zh-cn', //必须的，zh-cn或en-us 或其他，根据语言显示页面
            'plugins' => $my_plugin_id,//必须的，根据自己需要自定义插件ID，唯一的，匹配[a-zA-Z\d\-_]+
            'appid' => $appid, //必须的，APPID
            'trade_order_id' => $order->order_id, //必须的，网站订单ID，唯一的，匹配[a-zA-Z\d\-_]+
            'payment' => $request->get('payment', 'wechat'),//必须的，支付接口标识：wechat(微信接口)|alipay(支付宝接口)
            'type' => 'WAP',//固定值"WAP" H5支付必填
            'wap_url' => $domain,//网站域名，H5支付必填
            'wap_name' => env('HU_PI_PAY_HOME_NAME'),//网站域名，或者名字，必填，长度32或以内 H5支付必填
            'total_fee' => $order->price, //人民币，单位精确到分(测试账户只支持0.1元内付款)
            'title' => Helper::site_1_config('order_name'), //必须的，订单标题，长度32或以内
            'time' => time(),//必须的，当前时间戳，根据此字段判断订单请求是否已超时，防止第三方攻击服务器
            'notify_url' => $domain . '/api/pay/notify/hupi', //必须的，支付成功异步回调接口
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
        $url = $payMethod->api_url ?: static::networkUrl();

        try {
            Log::info('debug 请求支付:开始请求', ['url' => $url]);
            $result = HuPiPay::retry_http($url, $data);

            Log::info('debug 请求支付:开始请求', ['url' => $result]);


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

    public static function notify($payMethod = null, $request = null): string
    {
        $request = $request ?? request();
        $data = $request->post();
        Log::info('notify 测试', $data);

        foreach ($data as $k => $v) {
            $data[$k] = stripslashes($v);
        }

        if (!isset($data['hash']) || !isset($data['trade_order_id'])) {
            Log::info('参数不存在');
            return 'failed';
        }

        $my_plugin_id = env('HU_PI_PAY_APP_PLUGIN');


        //自定义插件ID,请与支付请求时一致
        if (isset($data['plugins']) && $data['plugins'] != $my_plugin_id) {
            Log::info('自定义插件ID,请与支付请求时一致');
            return 'failed';
        }

        //商户订单ID
        $trade_order_id = $data['trade_order_id'];

        $order = Order::query()
            ->where('order_id', $trade_order_id)
            ->first();

        if (!$order) {
            Log::info('notify 测试: 订单不存在', [
                $data
            ]);

            return 'failed';
        }
        $payMethod = $payMethod ?? $order->getPayment();

        $appsecret = data_get($payMethod, 'app_secret');//测试账户，

        $hash = HuPiPay::generate_xh_hash($data, $appsecret);
        if ($data['hash'] != $hash) {
            Log::info('签名验证失败');
            //签名验证失败
            return 'failed';
        }


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
