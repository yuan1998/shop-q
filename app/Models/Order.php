<?php

namespace App\Models;

use App\Helper;
use App\Http\Middleware\RestrictIpAddressMiddleware;
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
        self::PAY_ERROR => '支付失败',
        self::PAY_SUCCESS => '支付成功',
        self::SHIP => '已发货',
        self::PAY_OUTING => '退货/退款',
        self::CANCEL => '已取消',
    ];

    protected $fillable = [
        'ip',
        'computed',
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

    public static function validateCustomPhone($data)
    {
        $customInfo = is_array($data['custom_info']) ? $data['custom_info'] : json_decode($data['custom_info'], true);
        $phone = data_get($customInfo, '收货人电话');
        if (!$phone)
            throw new \Exception('错误的信息,收货人信息错误.');

        if (BlackList::phoneIsBlock($phone)) {
            RestrictIpAddressMiddleware::setBlock();
            return false;
        }
        return true;
    }

    public static function generateProductsOrder($data)
    {
        if (!static::validateCustomPhone($data))
            throw new \Exception('下单失败，请刷新页面.');

        $product = collect(data_get($data, 'product'));

        if ($product->isEmpty())
            throw new \Exception('错误的商品,商品不能为空.');

        $productId = $product->pluck('id')->unique();

        $productModel = Product::query()
            ->whereIn('id', $productId)
            ->get()
            ->groupBy('id');

        $payment = data_get($data, 'payment', 'wechat');
        $payChannel = PayChannel::getPayMethod($payment);

        $totalPrice = 0;
        $product = $product->map(function ($row) use ($productModel, &$totalPrice) {
            $id = data_get($row, 'id');
            $row['price'] = data_get($productModel, "$id.price", $row['price']);
            $totalPrice += $row['price'] * $row['count'];
            return $row;
        });

        $arr = [
            'snapshot' => $product->toJson(),
            'product_id' => $productId->join(','),
            'pay_method' => $payment,
            'custom_info' => data_get($data, 'custom_info'),
            'comment' => data_get($data, 'comment'),
            'order_id' => static::generateOrderId(),
            'status' => static::UN_PAY,
            'price' => $totalPrice,
            'ip' => request()->ip(),
            'pay_channel_id' => $payChannel->id,
        ];

        return Order::create($arr);
    }

    public static function generateOrder($data)
    {
        if (!static::validateCustomPhone($data))
            throw new \Exception('请刷新页面.');

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
            'comment' => data_get($data, 'comment'),
            'pay_channel_id' => $payChannel->id,
            'ip' => request()->ip(),
        ];

        return Order::create($arr);
    }

    public function getPayment()
    {
        return $this->pay_channel_id ? PayChannel::find($this->pay_channel_id)
            : PayChannel::getPayMethod($this->pay_method);
    }
}
