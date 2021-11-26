<?php

namespace App\Admin\Actions;

use App\Admin\Forms\Site1SettingConfigForm;
use Dcat\Admin\Actions\Action;
use Dcat\Admin\Widgets\Modal;

class Site1SettingConfig extends Action
{
    /**
     * @return string
     */
    protected $title = '<i class="feather icon-edit" style="font-size: 1.5rem"></i> 网站设置';

    public function render()
    {
        $modal = Modal::make()
            ->id('site1-setting-config') // 导航栏显示弹窗，必须固定ID，随机ID会在刷新后失败
            ->title($this->title())
            ->body(Site1SettingConfigForm::make())
            ->lg()
            ->button(
                <<<HTML
<ul class="nav navbar-nav">
     <li class="nav-item"> &nbsp;{$this->title()} &nbsp;</li>
</ul>
HTML
            );

        return $modal->render();
    }
}
