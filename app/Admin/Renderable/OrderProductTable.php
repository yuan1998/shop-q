<?php

namespace App\Admin\Renderable;

use App\Models\Order;
use Dcat\Admin\Support\LazyRenderable;
use Dcat\Admin\Widgets\Table;
use Faker\Factory;

class OrderProductTable extends LazyRenderable
{
    public function render()
    {
        $data = [];
        $id = data_get($this->payload, 'id', '');
        if (!$id || !($order = Order::query()
                ->select([
                    'snapshot'
                ])
                ->where('id', $id)
                ->first()
            )) {
            return "<div>错误的订单号,请刷新页面</div>";
        }
        $snapshot = json_decode($order->snapshot, true);

        if (!$snapshot)
            return "<div>Empty</div>";

        $snapshot = array_key_exists('id', $snapshot) ? collect([])->sort()->push($snapshot) : collect($snapshot);

        $data = $snapshot->map(function ($product) {
            $sku = is_array($product['sku']) ? $product['sku'] : json_decode($product['sku'], true);
            $sku = collect($sku)
                ->map(function ($val, $key) {
                    return "$key : $val";
                })->join('<br/>');


            return [
                'title' => data_get($product, 'title'),
                'sku' => $sku,
                'price' => data_get($product, 'price'),
                'count' => data_get($product, 'count'),
            ];

        });

        return Table::make(['商品', 'Sku', '价格', '数量'], $data);
    }
}
