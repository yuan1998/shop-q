<?php

namespace Dcat\Admin\GridSortable;

use Dcat\Admin\Extend\ServiceProvider;
use Dcat\Admin\Admin;

class GridSortableServiceProvider extends ServiceProvider
{
	protected $js = [
        'js/sortable.min.js',
    ];

	public function register()
	{
        $extension =  GridSortable::make();

        if ($views = $extension->views()) {
            $this->loadViewsFrom($views, GridSortable::NAME);
        }

        if ($lang = $extension->lang()) {
            $this->loadTranslationsFrom($lang, GridSortable::NAME);
        }

        if ($migrations = $extension->migrations()) {
            $this->loadMigrationsFrom($migrations);
        }

        $this->app->booted(function () use ($extension) {
            $extension->routes(__DIR__ . '/Http/routes.php');
        });

        $extension->boot();
	}

	public function init()
	{
		parent::init();


	}

	public function settingForm()
	{
		return new Setting($this);
	}
}
