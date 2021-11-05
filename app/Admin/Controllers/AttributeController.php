<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\Attribute;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class AttributeController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new Attribute(), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->column('name');
            $grid->column('attributes');
            $grid->column('skus');
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
        return Show::make($id, new Attribute(), function (Show $show) {
            $show->field('id');
            $show->field('name');
            $show->field('attributes');
            $show->field('skus');
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
        return Form::make(new Attribute(), function (Form $form) {
            $form->display('id');
            $form->text('name');
            $form->list('attributes')->saving(function ($v) {
                return json_encode($v);
            });
            $form->list('skus')->saving(function ($v) {
                return json_encode($v);
            });

            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
