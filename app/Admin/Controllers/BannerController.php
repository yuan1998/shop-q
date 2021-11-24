<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\Banner;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class BannerController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new Banner(), function (Grid $grid) {
            $grid->scrollbarX();

            $grid->column('name');
            $grid->column('image')->image('', 300, 300);
            $grid->column('url');
            $grid->column('show')->switch();
            $grid->column('order');
            $grid->column('created_at');
            $grid->sortable();


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
        return Show::make($id, new Banner(), function (Show $show) {
            $show->field('id');
            $show->field('name');
            $show->field('url');
            $show->field('image');
            $show->field('show');
            $show->field('order');
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
        return Form::make(new Banner(), function (Form $form) {
            $form->display('id');
            $form->text('name');
            $form->text('url');
            $form->image('image')
                ->removable(false)
                ->uniqueName()
                ->autoUpload();
            $form->switch('show')->default(1);

            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
