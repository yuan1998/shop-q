<?php

namespace App\Models;

use App\Payable\BSYiPay;
use App\Payable\ChangLianPay;
use App\Payable\FaCaiPay;
use App\Payable\HuPiPay;
use App\Payable\Mac169Pay;
use App\Payable\MaPay;
use App\Payable\MuJiePay;
use App\Payable\XunHuPay;
use App\Payable\YiPay;
use App\Payable\YouLianPay;

class PayChannel extends Model
{

    const HiPi = 'HU_PI_PAY';
    const XunHu = 'XUN_HU_PAY';
    const Mac169 = 'MAC_169_PAY';
    const MuJie = 'MU_JIE_PAY';
    const BSYi = 'BS_YI_PAY';
    const ChangLian = 'CHANG_LIAN_PAY';
    const YiPay = 'YI_PAY';
    const YouLianPay = 'YOU_LIAN_PAY';
    const MaPay = 'Ma_PAY';
    const FaCaiPay = 'Fa_Cai_Pay';

    public static $pay_method = [
        self::HiPi => '虎皮支付',
        self::XunHu => '虎皮支付2',
        self::Mac169 => 'MAC169支付',
        self::YiPay => '易支付',
        self::MuJie => '木皆支付',
        self::BSYi => 'BS易支付',
        self::ChangLian => '畅联支付',
        self::YouLianPay => '友联支付',
        self::FaCaiPay => '发财支付',
        self::MaPay => '码支付',
    ];

    public static $pay_model = [
        self::YouLianPay => YouLianPay::class,
        self::HiPi => HuPiPay::class,
        self::XunHu => XunHuPay::class,
        self::Mac169 => Mac169Pay::class,
        self::MuJie => MuJiePay::class,
        self::BSYi => BSYiPay::class,
        self::ChangLian => ChangLianPay::class,
        self::YiPay => YiPay::class,
        self::MaPay => MaPay::class,
        self::FaCaiPay => FaCaiPay::class,
    ];

    protected $fillable = [
        'app_key',
        'app_secret',
        'api_url',
        'type',
        'enable',
        'alipay_enable',
        'comment',
    ];

    public static function getPayMethod($payment = 'wechat')
    {
        $field = 'enable';
        if (in_array($payment, ['wechat', 'alipay'])) {
            $field = $payment === 'wechat' ? 'enable' : 'alipay_enable';
        }

        return static::query()
            ->select([
                'id',
                'app_key',
                'app_secret',
                'type',
                'enable',
                'alipay_enable',
            ])
            ->orderBy($field, 'desc')
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
