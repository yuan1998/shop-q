<?php


namespace App\Admin\Forms;

use App\Helper;
use App\Models\Order;
use Dcat\Admin\Contracts\LazyRenderable;
use Dcat\Admin\Traits\LazyWidget;
use Dcat\Admin\Widgets\Form;
use Illuminate\Support\Arr;

class RateForm extends Form implements LazyRenderable
{
    use LazyWidget;

    /**
     * 处理表单请求.
     *
     * @param array $input
     *
     * @return mixed
     */
    public function handle(array $input)
    {

        $this->update($input);

        return $this->response()->success('设置成功');
    }

    /**
     * 构建表单.
     */
    public function form()
    {
        foreach (Order::$paymentName as $key => $value) {
            $this->text("$key.rate", $value);
        }


    }

    /**
     * 设置接口保存成功后的回调JS代码.
     *
     * 1.2秒后刷新整个页面.
     *
     * @return string|void
     */
    public function savedScript()
    {
        return <<<'JS'
    if (data.status) {
        setTimeout(function () {
          location.reload()
        }, 1200);
    }
JS;
    }

    /**
     * 返回表单数据.
     *
     * @return array
     */
    public function default(): array
    {
        return Helper::site_1_config();
    }

    /**
     * 更新配置.
     *
     * @param array $inputs
     */
    protected function update(array $inputs)
    {
        Helper::site_1_config($inputs);
    }
}
