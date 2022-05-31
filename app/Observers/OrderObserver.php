<?php

namespace App\Observers;

use App\Admin\Actions\AccountLimit;
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
                $count = ceil((float)$order->price * (float)env('RATE'));
                AccountLimit::lessLimit($count);
            }

            Order::query()->where('id', $order->id)->update($arr);
        }
    }
}
