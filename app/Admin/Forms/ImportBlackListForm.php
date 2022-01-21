<?php

namespace App\Admin\Forms;

use Dcat\Admin\Contracts\LazyRenderable;
use Dcat\Admin\Traits\LazyWidget;
use Dcat\Admin\Widgets\Form;

class ImportBlackListForm extends Form implements LazyRenderable
{

    use LazyWidget;

    /**
     * Build a form here.
     */
    public function form()
    {
        // 获取外部传递参数

        $this->file('file','快递单号')->required();

    }
}
