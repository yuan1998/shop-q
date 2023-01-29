<?php

namespace App\Payable;

use App\Helper;
use App\Models\Order;
use App\Models\PayChannel;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;

class GuangSuPay extends JInXunDaPay
{
    public static $baseApi = "http://pay.guangsu.one/";
}
