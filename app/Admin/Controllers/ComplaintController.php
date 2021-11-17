<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\Complaint;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class ComplaintController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(Complaint::indexQuery(), function (Grid $grid) {
            $grid->quickSearch(['order_id', 'phone', 'wechat'])
            ->placeholder('输入 订单号/联系电话/微信号 查询数据');

            $grid->column('order_id');
            $grid->column('phone');
            $grid->column('wechat');
            $grid->column('comment');
            $grid->column('created_at');

            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('order_id');
                $filter->equal('phone');

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
        return Show::make($id, new Complaint(), function (Show $show) {
            $show->field('id');
            $show->field('order_id');
            $show->field('phone');
            $show->field('wechat');
            $show->field('comment');
            $show->field('created_at');
            $show->field('updated_at');
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new Complaint(), function (Form $form) {
            $form->display('id');
            $form->text('order_id');
            $form->text('phone');
            $form->text('wechat');
            $form->text('comment');

            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
