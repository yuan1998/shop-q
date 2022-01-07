<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\BlackList;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class BlackListController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new BlackList(), function (Grid $grid) {
            $grid->column('id')->sortable(null, 'desc');
            $grid->column('add_type')->using(\App\Models\BlackList::$addTypeList);
            $grid->column('type')->using(\App\Models\BlackList::$typeList);
            $grid->column('value');
            $grid->column('remark');
            $grid->column('created_at');

            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('id');
                $filter->like('value');
                $filter->equal('add_type')->select(\App\Models\BlackList::$addTypeList);
                $filter->equal('type')->select(\App\Models\BlackList::$typeList);
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
        return Show::make($id, new BlackList(), function (Show $show) {
            $show->field('id');
            $show->field('add_type');
            $show->field('type');
            $show->field('value');
            $show->field('remark');
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
        return Form::make(new BlackList(), function (Form $form) {
            $form->display('id');
            $form->select('add_type')
                ->options(\App\Models\BlackList::$addTypeList)
                ->default(\App\Models\BlackList::ADD_TYPE_MANUAL);
            $form->select('type')
                ->options(\App\Models\BlackList::$typeList)
                ->default(\App\Models\BlackList::TYPE_IP);

            $form->text('value');
            $form->text('remark');

            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
