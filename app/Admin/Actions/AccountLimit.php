<?php

namespace App\Admin\Actions;

use App\Admin\Forms\Site1SettingConfigForm;
use Dcat\Admin\Actions\Action;
use Dcat\Admin\Widgets\Modal;
use Illuminate\Support\Facades\Cache;

class AccountLimit extends Action
{
    const KEY = '__account_limit__';

    public static function getAccountLimit(): int
    {
        return (int)Cache::get(self::KEY, env('INIT_LIMIT'));
    }

    public static function setAccountLimit($value)
    {
        Cache::put(self::KEY, $value);
    }

    public static function lessLimit($value)
    {
        $count = static::getAccountLimit();
        static::setAccountLimit($count - $value);
    }

    public static function addLimit($value)
    {
        $count = static::getAccountLimit();
        static::setAccountLimit($count + $value);
    }

    public static function initLimit()
    {
        static::setAccountLimit(env('INIT_LIMIT'));
    }

    public static function isBlock(): bool
    {
        $count = static::getAccountLimit();
        $max = (int)env('MAX_LIMIT');
        return $count <= $max;
    }

    public function render()
    {
        $maxLimit = env('MAX_LIMIT');
        $count = static::getAccountLimit();
        return admin_view('admin.accountLimit', [
            'maxLimit' => $maxLimit,
            'count' => $count,
        ]);
    }
}