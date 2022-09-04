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
        $this->text('logistic_url', '快递链接')->help('快递链接');
        $this->text('wan_qiao_pay_code', '环球支付通道')->help('环球支付通道');
        $this->switch('disable_wechat', '隐藏微信支付')->help('隐藏微信支付');
        $this->switch('disable_alipay', '隐藏支付宝')->help('隐藏支付宝');
        $this->switch('payment_sort', '默认支付倒转')->help('默认支付倒转');
        $this->text('mac169_api', 'mac169网关')->help('mac169网关');


        switch (env('SITE_NAME', 'site1')) {
            case 'site1' :
                $this->text('index_header_image', '首页头图')->required()->help('首页头图');
                $this->text('product_info_image', '商品信息')->required()->help('商品信息(7天无理由部位)');
                $this->text('product_image', '商品页店铺图')->required()->help('商品页店铺图');
                break;
            case "site2" :
                $this->text('index_header_image', '首页头图')->required()->help('首页头图');
                $this->text('order_header_image', '订单页面头图')->help('订单页面头图');
                $this->text('product_image', '商品页店铺图')->help('商品页店铺图');
                break;
        }

        $this->divider();
        $this->embeds('亿美', function ($form) {

            $form->text('api_domain', '域名网管')->required();
            $form->text('wechat', '微信')->required();
            $form->text('alipay', '支付宝')->required();
        });
        $this->embeds('ZBPAY', function ($form) {
            $form->text('wechat', '微信')->required();
            $form->text('alipay', '支付宝')->required();
        });

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
