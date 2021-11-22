<?php

namespace App\Observers;

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
        if ($order->status === Order::PAY_SUCCESS) {
            $order->pay_date = Carbon::now()->toDateTimeString();
            $order->save();
        }
    }
}
