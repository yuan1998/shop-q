<?php

namespace App\Admin\Grid\Tools;

use App\Admin\Forms\ImportBlackListForm;
use Dcat\Admin\Grid\Tools\AbstractTool;
use Dcat\Admin\Widgets\Modal;

class ImportBlackList extends AbstractTool
{
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
    public $title = '上传名单';

    public function render()
    {
        // 实例化表单类并传递自定义参数
        $form = ImportBlackListForm::make()->payload(['id' => $this->getKey()]);

        return Modal::make()
            ->lg()
            ->title($this->title)
            ->body($form)
            ->button($this->title);
    }


}
