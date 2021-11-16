<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\PayChannel;
use App\Models\Order;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class PayChannelController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new PayChannel(), function (Grid $grid) {
            $grid->quickCreate(function (Grid\Tools\QuickCreate $create) {
                $create->text('app_key')->required();
                $create->text('app_secret')->required();
                $create->select('type')
                    ->options(\App\Models\PayChannel::$pay_method)
                    ->required();
            });

            $grid->column('id')->sortable();
            $grid->column('app_key');
            $grid->column('app_secret');
            $grid->column('type');
            $grid->column('enable')->switch();
            $grid->column('created_at');

            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('id');

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
        return Show::make($id, new PayChannel(), function (Show $show) {
            $show->field('id');
            $show->field('app_key');
            $show->field('app_secret');
            $show->field('type');
            $show->field('enable');
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
        return Form::make(new PayChannel(), function (Form $form) {
            $form->display('id');
            $form->text('app_key')->required();
            $form->text('app_secret')->required();
            $form->select('type')
                ->options(\App\Models\PayChannel::$pay_method)->required();
            $form->switch('enable');

            $form->display('created_at');
            $form->display('updated_at');

            $form->saving(function (Form $form) {
                $enable = $form->input('enable');
                if ($enable) {
                    \App\Models\PayChannel::query()
                        ->update([
                            'enable' => false,
                        ]);
                }
            });

        });
    }
}
