<?php

namespace dam1r89\TestHooks\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Session\Store;

class TestDatesMiddleware
{
    /**
     * @var Store
     */
    private $store;


    /**
     * TestDatesMiddleware constructor.
     */
    public function __construct(Store $store)
    {
        $this->store = $store;
    }

    public function handle($request, Closure $next)
    {

        if (!$this->store->has('test-date')) {
            return $next($request);
        }
        Carbon::setTestNow($this->store->get('test-date'));
        $response = $next($request);
        Carbon::setTestNow();
        return $response;
    }
}
