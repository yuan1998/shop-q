<?php

namespace App\Admin\Controllers;

use App\Admin\Exporters\OrderExporter;
use App\Admin\Forms\OrderLogisticNumber;
use App\Admin\Renderable\ProductTable;
use App\Admin\Repositories\Order;
use App\Models\Product;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;
use Dcat\Admin\Widgets\Card;

class OrderController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {

        return Grid::make(Order::indexQuery(), function (Grid $grid) {
            $grid->scrollbarX();

            $grid->export(new OrderExporter());

            $grid->disableCreateButton();
            $grid->disableEditButton();

            $grid->column('order_id');
            $grid->column('snapshot', '订单商品')
                ->expand(function (Grid\Displayers\Expand $expand) {
                    $expand->button('详情');
                    return ProductTable::make()->payload([
                        'id' => $this->id,
                    ]);
                });

            $grid->column('price')
                ->display(function ($value) {
                    return "{$value}元";
                })
                ->style("color:red;");

            $grid->column('status')
                ->select(\App\Models\Order::$payStatus, true);

            $grid->column('pay_method');
            $grid->column('pay_date');
            $grid->column('logistic_number', '快递单号')
                ->display(function ($val) {
                    return $val ?? '未发货';
                })
                ->if(function () {
                    return $this->status !== \App\Models\Order::UN_PAY ;
                })
                ->modal(function (Grid\Displayers\Modal $modal) {
                    // 标题
                    $modal->title('快递单号');
                    // 自定义图标
                    $modal->icon('feather icon-edit');

                    // 传递当前行字段值
                    return OrderLogisticNumber::make()->payload([
                        'id' => $this->id,
                    ]);
                });


            $grid->column('custom_info')
                ->display(function ($value) {
                    return collect(json_decode($value, true))
                        ->map(function ($val, $key) {
                            return "$key : $val";
                        })->join('<br/>');
                });

            $grid->column('created_at');

            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('order_id');
                $filter->equal('status')->select(\App\Models\Order::$payStatus);
                $filter->like('custom_info', '收货人/收货人电话');
            });
        });
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     *
     * @return Show
     */
    protected function detail($id)
    {
        return Show::make($id, new Order(), function (Show $show) {
            $show->field('id');
            $show->field('pay_date');
            $show->field('product_id');
            $show->field('snapshot');
            $show->field('product_sku');
            $show->field('custom_info');
            $show->field('status');
            $show->field('pay_method');
            $show->field('pay_info');
            $show->field('price');
            $show->field('order_id');
            $show->field('created_at');
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new Order(), function (Form $form) {
            $form->display('id');
            $form->text('pay_date');
            $form->text('product_id');
            $form->text('snapshot');
            $form->text('product_sku');
            $form->text('custom_info');
            $form->text('status');
            $form->text('pay_method');
            $form->text('pay_info');
            $form->text('price');
            $form->text('order_id');
            $form->text('logistic_number');

            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
