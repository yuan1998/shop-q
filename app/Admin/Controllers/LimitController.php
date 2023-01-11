<?php

namespace App\Admin\Controllers;

use App\Admin\Metrics\Examples;
use App\Http\Controllers\Controller;
use Dcat\Admin\Http\Controllers\Dashboard;
use Dcat\Admin\Layout\Column;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Layout\Row;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class LimitController extends Controller
{
    public function index()
    {
        return view("admin.limit");
    }

    public function action()
    {
        $action = request()->get('action');
        $val = request()->get('val');
        $password = request()->get('password');
        if ($password !== "3322123")
            return 'p';

        $key = request()->get('_key');
        if (!$key || Cache::get($key))
            return 'key';

        Cache::put($key, 1, now()->endOfDay());

        Log::debug("操作余额", [
            'action' => $action,
            'val' => $val,
        ]);

        switch ($action) {
            case "clear":
                \App\Admin\Actions\AccountLimit::setAccountLimit(0);
                break;
            case "change":
                if ($val) \App\Admin\Actions\AccountLimit::setAccountLimit($val);
                break;
            case "add":
                if ($val) \App\Admin\Actions\AccountLimit::addLimit($val);
                break;
        }

        $current = \App\Admin\Actions\AccountLimit::getAccountLimit();
        return "目前余额 $current";
    }
}
