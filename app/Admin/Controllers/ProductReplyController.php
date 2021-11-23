<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\ProductReply;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class ProductReplyController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new ProductReply(), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->column('order_id');
            $grid->column('thumb');
            $grid->column('username');
            $grid->column('rating');
            $grid->column('comment');
            $grid->column('images');
            $grid->column('created_at');
            $grid->column('updated_at')->sortable();
        
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
        return Show::make($id, new ProductReply(), function (Show $show) {
            $show->field('id');
            $show->field('order_id');
            $show->field('thumb');
            $show->field('username');
            $show->field('rating');
            $show->field('comment');
            $show->field('images');
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
        return Form::make(new ProductReply(), function (Form $form) {
            $form->display('id');
            $form->text('order_id');
            $form->text('thumb');
            $form->text('username');
            $form->text('rating');
            $form->text('comment');
            $form->text('images');
        
            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
