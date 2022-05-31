<?php

namespace App\Providers;

use App\Models\BlackList;
use App\Models\Order;
use App\Observers\BlackListObserver;
use App\Observers\OrderObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Order::observe(OrderObserver::class);
        BlackList::observe(BlackListObserver::class);
    }
}
