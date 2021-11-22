<?php

namespace App\Models;

use App\Helper;
use Illuminate\Support\Facades\DB;

class Order extends Model
{

    const UN_PAY = 1;
    const PAY_SUCCESS = 2;
    const PAY_ERROR = 3;
    const PAY_OUTING = 4;
    const SHIP = 5;
    const CANCEL = 6;

    public static $paymentName = [
        'wechat' => '微信支付',
        'alipay' => '支付宝',
    ];

    public static $payStatus = [
        self::UN_PAY => '未支付',
        self::PAY_SUCCESS => '支付成功',
        self::PAY_ERROR => '支付失败',
        self::PAY_OUTING => '退货/退款',
        self::SHIP => '已发货',
        self::CANCEL => '已取消',
    ];

    protected $fillable = [
        'pay_date',
        'product_id',
        'snapshot',
        'product_sku',
        'custom_info',
        'status',
        'pay_method',
        'pay_info',
        'price',
        'order_id',
        'logistic_number',
        'pay_channel_id',
        'send_at',
        'return_status',
        'return_at',
        'return_reason',
        'return_location',
        'return_logistics_number',
        'comment',
    ];

    protected $casts = [
        'snapshot' => 'json',
        'product_sku' => 'json',
        'custom_info' => 'json',
        'pay_info' => 'json',
    ];

    public static function getTableName(): string
    {
        return (new self())->getTable();
    }

    public static function generateOrderId(): string
    {
        $table = static::getTableName();
        $statement = DB::select("SHOW TABLE STATUS LIKE '$table'");
        $nextId = $statement[0]->Auto_increment;
        $date = date('YmdHis');
        $r1 = Helper::randomNumber(3);
        $r2 = Helper::randomNumber(2);
        return "$date$r1$nextId$r2";
    }

    public static function generateOrder($data)
    {
        $productId = data_get($data, 'product_id');
        if (!$productId || !($product = Product::find($productId)))
            throw new \Exception('错误的商品ID,请在正确的页面下单.');

        $product->sku = data_get($data, 'product_sku');
        $product->count = data_get($data, 'count');


        $payment = data_get($data, 'payment', 'wechat');
        $payChannel = PayChannel::getPayMethod($payment);

        $arr = [
            'snapshot' => json_encode($product),
            'product_id' => $productId,
            'pay_method' => $payment,
            'custom_info' => data_get($data, 'custom_info'),
            'order_id' => static::generateOrderId(),
            'status' => static::UN_PAY,
            'price' => data_get($data, 'price'),
            'pay_channel_id' => $payChannel->id,
        ];

        return Order::create($arr);
    }

    public function getPayment()
    {
        return $this->pay_channel_id ? PayChannel::find($this->pay_channel_id)
            : PayChannel::getPayMethod($this->pay_method);
    }
}
