<?php

namespace App\Admin\Controllers;

use App\Admin\Forms\DispatchCategories;
use App\Admin\Renderable\ProductTable;
use App\Admin\Repositories\Product;
use App\Models\Attribute;
use App\Models\Category;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;
use Dcat\Admin\Widgets\Alert;

class ProductController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(Product::indexQuery(), function (Grid $grid) {
            $grid->scrollbarX();
            $grid->tableCollapse(false);

            $grid->column('id');
            $grid->column('title');
            $grid->column('price')
                ->display(function ($value) {
                    return "{$value}元";
                })->style("color:red;");
            $grid->column('sales');
            $grid->column('categories')
                ->display(function ($value) {
                    $title = data_get($value, '0.title', '');

                    if (!$title)
                        return '未设置';

                    $count = count($value);
                    return $title . ($count > 1 ? ' ,等' . $count . '个分类' : '');

                })
                ->modal(function (Grid\Displayers\Modal $modal) {
                    // 标题
                    $modal->title('弹窗标题');
                    // 自定义图标
                    $modal->icon('feather icon-edit');

                    // 传递当前行字段值
                    return DispatchCategories::make()->payload([
                        'id' => $this->id,
                        'categories' => $this->categories->pluck('id')->toJson()
                    ]);
                });
            $grid->column('images')->display(function ($pictures) {
                return collect(json_decode($pictures, true))->pluck('value');

            })->image('', 100, 100);


            $grid->column('attributes')->display(function ($value) {
                $value = json_decode($value, true);
                return collect($value)->map(function ($v, $key) {
                    return "$key : " . $v;
                })->join('<br>');
            });
            $grid->column('skus')->display(function ($value) {
                $value = json_decode($value, true);
                return collect($value)->map(function ($v, $key) {
                    return "$key : " . collect($v)->pluck('title')->join(',');
                })->join('<br>');
            });
            $grid->column('show')->switch();
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
        return Show::make($id, new Product(), function (Show $show) {
            $show->field('id');
            $show->field('title');
            $show->field('price');
            $show->field('sales');
            $show->field('description');
            $show->field('images');
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
        return Form::make(Product::with(['categories']), function (Form $form) {

            if ($form->isCreating()) {
                $form->text('title')->required();
                $form->select('attribute_id', '属性')
                    ->options(Attribute::all(['name', 'id'])->pluck('name', 'id'))
                    ->required();
                $form->defaultEditingChecked();
                return;
            };

            $model = $form->model();
            $attribute = Attribute::find($model->attribute_id);

            $form->hidden('skus');
            $form->text('title')->required();
            $form->currency('price')->symbol('¥')->required();
            $form->switch('show')->required()->default(1);
            $form->number('sales')->required()->min(0);

            $form->embeds('attributes', function ($form) use ($attribute) {
                $attributes = json_decode($attribute->attributes);
                foreach ($attributes as $attribute) {
                    $form->text($attribute)->required();
                }
            })->saving(function ($v) {
                // 转化为json格式存储
                return json_encode($v);
            })->required();

            $skus = json_decode($attribute->skus);
            $skusValue = json_decode($model->skus, true);

            foreach ($skus as $sku) {

                $form->table($sku, function ($form) {
                    $form->image('value', '图片')
                        ->autoUpload()
                        ->width(50)
                        ->removable(false);
                    $form->text('title', '名称')->required();
//                    $form->number('stock' , '库存')->default(0)->width(50);

                })->value(data_get($skusValue, $sku, []))->saveAsJson()->required();
            }


            $form->table('images', '轮播图', function ($form) {
                $form->image('value', '轮播图')
                    ->autoUpload()
                    ->removable(false)
                    ->required();
            })->saveAsJson()->required();

            $form->editor('description')->required();


            $form->tree('categories', '分配分类')
                ->expand(false)
                ->treeState(false)
                ->setTitleColumn('title')
                ->nodes((new Category())->allNodes())
                ->customFormat(function ($v) {
                    if (!$v) return [];

                    // 这一步非常重要，需要把数据库中查出来的二维数组转化成一维数组
//                    dd(array_column($v, 'id'));
                    return array_column($v, 'id');
                });


            $form->saving(function (Form $form) use ($skus) {
                // 判断是否是新增操作
                if (!$form->isCreating()) {
                    $arr = [];
                    $inputs = $form->input();
                    if (array_key_exists('skus', $inputs)) {
                        foreach ($skus as $sku) {
                            $arr[$sku] = data_get($inputs, $sku);
                            $form->deleteInput($sku);
                        }
                        $form->input('skus', json_encode($arr));
                    }

                }
            });
        });
    }
}
