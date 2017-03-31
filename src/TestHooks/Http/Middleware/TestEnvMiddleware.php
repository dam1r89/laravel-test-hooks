<?php

namespace dam1r89\TestHooks\Http\Middleware;

use Closure;

class TestEnvMiddleware
{
    public function handle($request, Closure $next)
    {
        if (app()->environment(config('testhooks.env'))) {
            return $next($request);
        }
        return response(['success' => false, 'message' => 'Not allowed'], 400);
    }
}
