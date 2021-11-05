<?php

namespace App\Admin\Renderable;

use App\Models\Order;
use Dcat\Admin\Support\LazyRenderable;
use Dcat\Admin\Widgets\Table;
use Faker\Factory;

class ProductTable extends LazyRenderable
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
            $sku = collect(json_decode($product['sku'], true))
                ->map(function ($val, $key) {
                    return "$key : $val";
                })->join('<br/>');


            return [
                'title' => $product['title'],
                'sku' => $sku,
                'price' => $product['price'],
            ];

        });

        return Table::make(['商品', 'Sku', '价格'], $data);
    }
}
