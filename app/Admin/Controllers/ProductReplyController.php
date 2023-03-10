<?php

namespace App\Admin\Controllers;

use App\Admin\Renderable\ProductTable;
use App\Admin\Repositories\ProductReply;
use App\Models\Product;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;
use Faker\Generator;
use Illuminate\Support\Facades\Storage;

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
            $grid->scrollbarX();
            $grid->column('id')->sortable();
            $grid->column('order_id');
            $grid->column('thumb')
                ->image('', 50, 50);
            $grid->column('username');
            $grid->column('rating');
            $grid->column('comment');
            $grid->column('images')
                ->display(function ($val) {
                    return collect(json_decode($val, true));
                })
                ->image('', 50, 50);
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
            // ?????????????????????????????????
            $form->selectTable('order_id')
                ->required()
                ->from(ProductTable::make(['id' => $form->getKey()]))
                ->model(Product::class, 'id', 'title'); // ????????????????????????

            $form->text('thumb', '????????????')
                ->placeholder('??????????????????,????????????????????????.')
                ->help('??????<a href="https://www.superbed.cn/">????????????</a> ???????????????????????????????????????,???????????????????????????');

            $form->text('username')
                ->placeholder('??????????????????,????????????????????????.');

            $form->slider('rating')
                ->options([
                    'max' => 5, 'min' => 1, 'step' => 0.5,
                ])
                ->default(5);
            $form->textarea('comment')
                ->placeholder('??????????????????,????????????????????????.');
            // ?????????????????????????????????
            $form->list('images')
                ->saveAsJson()
                ->help('??????<a href="https://www.superbed.cn/">????????????</a> ???????????????????????????????????????,???????????????????????????');

            $form->display('created_at');
            $form->display('updated_at');
            $form->saving(function (Form $form) {
                $faker = \Faker\Factory::create();

                if (!$form->input('thumb')) {
                    $result = file_get_contents("https://picsum.photos/200");
                    $imagePath = '';
                    if ($result) {
                        $path = 'faker/' . sha1(time()) . "_avatar.jpg";
                        if (Storage::disk('public')->put($path, $result))
                            $imagePath = $path;

                    }
                    if (!$imagePath) {

                        $imagePath = $faker->image(storage_path('app/public/faker'), 200, 200, null, false);
                        $form->input('thumb', "faker/$imagePath");
                    }
                    $form->input('thumb', $imagePath);
                }
                if (!$form->input('username')) {
                    $form->input('username', $faker->userName());
                }
                if (!$form->input('comment')) {
                    $form->input('comment', $faker->randomElement(config('replycomment')));
                }
            });
        });
    }
}
