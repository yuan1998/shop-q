<?php

namespace App\Models;

use App\Helper;
use Illuminate\Support\Facades\DB;

class Order extends Model
{

    const UN_PAY = 1;

    const PAY_SUCCESS = 2;

    const PAY_ERROR = 3;

    public static $payStatus = [
        self::UN_PAY => '未支付',
        self::PAY_SUCCESS => '支付成功',
        self::PAY_ERROR => '支付失败',
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

        $arr = [
            'snapshot' => json_encode($product),
            'product_id' => $productId,
            'custom_info' => data_get($data, 'custom_info'),
            'order_id' => static::generateOrderId(),
            'status' => static::UN_PAY,
            'price' => data_get($data, 'price')
        ];

        return Order::create($arr);
    }
}
