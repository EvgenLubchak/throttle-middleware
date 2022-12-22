<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Exceptions\ThrottleRequestsException;

class Throttling
{
    /**
     * @param Request $request
     * @param Closure $next
     * @param int $requests request counter
     * @param int $time in seconds
     * @return mixed
     */
    public function handle(Request $request, Closure $next, int $requests, int $time)
    {
        if (Cache::has($request->ip())) {
            if (Cache::get($request->ip()) >= $requests) {
                throw new ThrottleRequestsException('Too many attempts!');
            }
            Cache::increment($request->ip());
        }
        Cache::add($request->ip(), 1, $time);
        return $next($request);
    }
}
