<?php

namespace App\Observers;

use App\Admin\Actions\AccountLimit;
use App\Helper;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class OrderObserver
{
    public function saved(Order $order)
    {
        Log::info('order observer 测试 : $order', [
            $order
        ]);
        if ($order->status == Order::PAY_SUCCESS) {
            $arr = [
                'pay_date' => Carbon::now()->toDateTimeString(),
            ];

            if (!$order->computed) {
                $arr['computed'] = true;

                $rate = Helper::site_1_config("$order->pay_method.rate") ?: config('accountlimit.RATE');
                $rate = (float)$rate;
                if (!$rate)
                    $rate = 0.05;
                Log::debug("pp$rate$order->pay_method");
                $count = ceil((float)$order->price * $rate);

                AccountLimit::lessLimit($count);
            }

            Order::query()->where('id', $order->id)->update($arr);
        }
    }
}
