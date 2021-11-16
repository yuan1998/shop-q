<?php

namespace App\Admin\Exporters;

use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\DefaultValueBinder;
use PhpOffice\PhpSpreadsheet\Cell\DataType;


class OrderExporter extends BaseExporter implements WithHeadings, WithCustomValueBinder, WithStrictNullComparison
{

    public function headings(): array
    {
        return [
            '订单号',
            '商品名称',
            '商品价格',
            'SKU',
            '购买数量',
            '订单状态',
            '支付时间',
            '支付方法',
            '收货人',
            '收货人电话',
            '收货人地址',
            '订单创建时间',
        ];
    }

    /**
     * 将数值转换为字符串
     *
     * @param \PhpOffice\PhpSpreadsheet\Cell\Cell $cell
     * @param mixed $value
     * @return boolean
     */
    public function bindValue(\PhpOffice\PhpSpreadsheet\Cell\Cell $cell, $value)
    {

        // 重写数据类型的判断规则
        if (is_numeric($value) && strlen($value) > 5 && preg_match('/^[\+\-]?(\d+\\.?\d*|\d*\\.?\d+)([Ee][\-\+]?[0-2]?\d{1,3})?$/', $value)) {
            $cell->setValueExplicit($value, DataType::TYPE_STRING);
            return true;
        }
        // 继承DefaultValueBinder
        $default = new DefaultValueBinder();
        return $default->bindValue($cell, $value);
    }


    public function collection(): \Illuminate\Support\Collection
    {
        $rows = parent::collection();

        $result = [];
        foreach ($rows as $row) {
            $status = \App\Models\Order::$payStatus[$row['status']];
            $snapshot = json_decode($row['snapshot'], true);
            $snapshot = array_key_exists('id', $snapshot)
                ? collect([])->push($snapshot)
                : collect($snapshot);
            $custom = json_decode($row['custom_info'], true);

            foreach ($snapshot as $product) {
                array_push($result, [
                    data_get($row, 'order_id'),
                    data_get($product, 'title'),
                    data_get($product, 'price'),
                    collect(json_decode(data_get($product, 'sku'), true))->map(function ($value, $key) {
                        return "$key : $value";
                    })->join(''),
                    data_get($product, 'count', 1),
                    $status,
                    data_get($row, 'pay_date'),
                    data_get($row, 'pay_method', '微信支付'),
                    data_get($custom, '收货人'),
                    data_get($custom, '收货人电话'),
                    data_get($custom, '收货人地址'),
                    data_get($row, 'created_at'),
                ]);
            }
        }
        return collect($result);
    }
}
