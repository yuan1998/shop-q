<?php

namespace App\Http\Middleware;

use App\Models\BlackList;
use Carbon\Carbon;
use Closure;

class RestrictIpAddressMiddleware
{
    const DISABLE_KEY = '_ip_block_';
    const ACCESS_KEY = '_ip_pass_';

    public static function setBlock()
    {
        session()->put(self::DISABLE_KEY, true);
    }

    public static function clearBlock()
    {
        session()->put(self::DISABLE_KEY, false);
    }

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (session(self::DISABLE_KEY)) {
            return redirect('/404');
        }

        $accessValue = session(self::ACCESS_KEY);
        if (!($accessValue && Carbon::now()->timestamp - $accessValue < 0)) {
            $ipAddress = BlackList::config('ip');
            if ($ipAddress->search($request->ip()) === false) {
                session()->put(self::ACCESS_KEY, Carbon::now()->addMinutes(5)->timestamp);
            } else {
                static::setBlock();
                return redirect('/404');
            }
        }

        return $next($request);
    }
}
