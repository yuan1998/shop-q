<?php
namespace App\Admin\Forms;

use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use Dcat\Admin\Contracts\LazyRenderable;
use Dcat\Admin\Traits\LazyWidget;
use Dcat\Admin\Widgets\Form;

class OrderLogisticNumber extends Form implements LazyRenderable
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
        if (!$id || !($p = Order::find($id)))
            return $this->response()
                ->error('设置快递单号错误,没有订单ID! 请正确使用')
                ->refresh();

        $value = data_get($input, 'logistic_number','');

        $p->logistic_number = $value;
        $p->save();

        return $this
            ->response()
            ->success('设置快递单号成功.')
            ->refresh();
    }

    /**
     * Build a form here.
     */
    public function form()
    {
        // 获取外部传递参数

        $this->text('logistic_number','快递单号')->required();

    }

    /**
     * The data of the form.
     *
     * @return array
     */
    public function default()
    {
        // 获取外部传递参数

        return [
        ];
    }
}
