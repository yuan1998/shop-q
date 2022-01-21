<?php
namespace App\Admin\Grid\Tools;

use Dcat\Admin\Grid\Tools\AbstractTool;

class ImportBlackList extends AbstractTool {
    /**
     * 按钮样式定义，默认 btn btn-white waves-effect
     *
     * @var string
     */
    protected $style = 'btn btn-white waves-effect';


    /**
     * 按钮文本
     *
     * @return string|void
     */
    public function title()
    {
        return '上传名单';
    }

    public function form() {
        $this->password('password')->required();

    }

    /**
     * 处理请求
     * 如果你的类中包含了此方法，则点击按钮后会自动向后端发起ajax请求，并且会通过此方法处理请求逻辑
     *
     * @param Request $request
     */
    public function handle(Request $request)
    {
        // 你的代码逻辑

        return $this->response()->success('发送成功')->refresh();
    }

    /**
     * 设置请求参数
     *
     * @return array|void
     */
    public function parameters()
    {
        return [

        ];
    }

}
