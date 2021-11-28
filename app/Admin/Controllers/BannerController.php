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
        return Form::make(Banner::indexQuery(), function (Form $form) {
            $form->display('id');
            $form->text('name');

            $form->radio('radio-image', '图片上传方式')
                ->when(2, function (Form $form) {
                    $form->file('image_upload', '上传图片')
                        ->autoUpload()
                        ->removable(false)
                        ->uniqueName();
                })
                ->when(1, function (Form $form) {
                    $form->text('image', '图片')
                        ->help('如果类型为图片,则显示图片.如果类型为视频,则显示为视频封面.');
                })
                ->options([
                    1 => '网络链接',
                    2 => '手动上传',
                ])
                ->value(1);

            $form->text('url');

            $form->switch('show')->default(1);

            $form->display('created_at');
            $form->display('updated_at');

            $form->saving(function (Form $form) {
                if ($upload = $form->input('image_upload')) {
                    $form->input('image', $upload);
                }

                $form->deleteInput([
                    'radio-image',
                    'image_upload',
                ]);
            });
        });
    }
}
