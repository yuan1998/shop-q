<?php


namespace App\Admin\Forms;

use App\Helper;
use Dcat\Admin\Contracts\LazyRenderable;
use Dcat\Admin\Traits\LazyWidget;
use Dcat\Admin\Widgets\Form;
use Illuminate\Support\Arr;

class Site1SettingConfigForm extends Form implements LazyRenderable
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
        $this->text('web_title', '网站名称')->required()->help('网站名称');
        $this->text('order_name', '订单标题')->required()->help('订单标题');
        $this->text('customer_phone', '客服电话')->required()->help('客服电话');
        $this->text('customer_wechat', '客服微信')->required()->help('客服微信');
        $this->text('xunhu_api', '迅虎网关')->required()->help('迅虎网关');
        $this->text('xunhu_api_2', '迅虎网关2')->required()->help('迅虎网关2');
        $this->text('mac169_api', 'MAC169网关')->required()->help('MAC169网关');
        $this->switch('disable_wechat', '隐藏微信支付')->help('隐藏微信支付');
        $this->switch('disable_alipay', '隐藏支付宝')->help('隐藏支付宝');
        $this->text('index_header_image', '首页头图')->required()->help('首页头图');
        $this->text('product_image', '商品页店铺图')->required()->help('商品页店铺图');
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
