<?php
namespace App\Models;

use App\Payable\BSYiPay;
use App\Payable\HuPiPay;
use App\Payable\MuJiePay;

class PayChannel extends Model
{

    const HiPi = 'HU_PI_PAY';
    const MuJie = 'MU_JIE_PAY';
    const BSYi = 'BS_YI_PAY';

    public static $pay_method = [
        self::HiPi => '虎皮支付',
        self::MuJie => '木皆支付',
        self::BSYi => 'BS易支付',
    ];

    public static $pay_model = [
        self::HiPi => HuPiPay::class,
        self::MuJie => MuJiePay::class,
        self::BSYi => BSYiPay::class,
    ];

    protected $fillable = [
        'app_key',
        'app_secret',
        'type',
        'enable',
        'alipay_enable',
        'comment',
    ];

    public static function getPayMethod()
    {
        $payment = request()->get('payment', 'wechat');

        return static::query()
            ->select([
                'id',
                'app_key',
                'app_secret',
                'type',
                'enable',
                'alipay_enable',
            ])
            ->orderBy('enable', 'desc')
            ->first();
    }

    public function payment($order, $request)
    {
        $model = data_get(static::$pay_model, $this->type);
        if (!$model)
            throw new \Exception('支付方法错误,未配置的支付方法');

        return $model::payment($order, $this, $request);
    }

    public function notify($request)
    {
        $model = data_get(static::$pay_model, $this->type);
        if (!$model)
            throw new \Exception('支付方法错误,未配置的支付方法');

        return $model::notify($this, $request);
    }

    public function handleReturn($request)
    {
        $model = data_get(static::$pay_model, $this->type);
        if (!$model)
            throw new \Exception('支付方法错误,未配置的支付方法');

        return $model::handleReturn($request);
    }
}
