<?php

namespace App\Admin\Renderable;

use App\Models\Product;
use Dcat\Admin\Grid;
use Dcat\Admin\Grid\LazyRenderable;


class ProductTable extends LazyRenderable
{


    public function grid(): Grid
    {
        // 获取外部传递的参数
        $id = $this->id;
        return Grid::make(new Product(), function (Grid $grid) {
            $grid->scrollbarX();
            $grid->column('id');
            $grid->column('images')->display(function ($pictures) {
                return collect(json_decode($pictures, true))->pluck('value');

            })->image('', 80, 80);
            $grid->column('title','商品标题');
            $grid->column('price','活动价');
            $grid->column('origin_price','划线价');
            $grid->quickSearch(['id', 'title']);

            $grid->paginate(10);
            $grid->disableActions();

            $grid->filter(function (Grid\Filter $filter) {
                $filter->like('title')->width(4);
            });
        });
    }
}
