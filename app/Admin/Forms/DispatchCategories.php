<?php

namespace App\Admin\Forms;

use App\Models\Category;
use App\Models\Product;
use Dcat\Admin\Contracts\LazyRenderable;
use Dcat\Admin\Traits\LazyWidget;
use Dcat\Admin\Widgets\Form;

class DispatchCategories extends Form implements LazyRenderable
{

    use LazyWidget;

    // 使用异步加载功能

    /**
     * Handle the form request.
     *
     * @param array $input
     *
     * @return mixed
     */
    public function handle(array $input)
    {
        $id = data_get($this->payload, 'id', null);
        if (!$id || !($p = Product::find($id)))
            return $this->response()
                ->error('设置分类错误,没有商品ID! 请正确使用')
                ->refresh();

        $value = data_get($input, 'categories', []);

        $p->categories()->sync($value);

        return $this
            ->response()
            ->success('设置分类成功.')
            ->refresh();
    }

    /**
     * Build a form here.
     */
    public function form()
    {
        // 获取外部传递参数

        $this->tree('categories', '分配分类')
            ->expand(false)
            ->treeState(false)
            ->setTitleColumn('title')
            ->nodes((new Category())->allNodes());

    }

    /**
     * The data of the form.
     *
     * @return array
     */
    public function default()
    {
        // 获取外部传递参数
        $categories = json_decode(data_get($this->payload, 'categories', null), true);
//        dd('default', $categories);

        return [
            'categories' => $categories,
        ];
    }
}
