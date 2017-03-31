<?php
namespace dam1r89\TestHooks;

use dam1r89\TestHooks\Http\Middleware\TestDatesMiddleware;
use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;


class TestHooksServiceProvider extends ServiceProvider
{

    private $namespace = 'dam1r89\TestHooks\Http\Controller';
    private $prefix = 'test-hooks';

    public function register()
    {
        $this->publishes([__DIR__ . '/config.php' => config_path('testhooks.php')], 'testhooks');
    }


    public function boot()
    {
        $this->mergeConfigFrom(__DIR__ . '/config.php', 'testhooks');
        $this->app->call([$this, 'map']);
    }

    public function map(Router $router)
    {
        $router->pushMiddlewareToGroup('web', TestDatesMiddleware::class);

        $router->group([
            'namespace' => $this->namespace,
            'middleware' => config('testhooks.middleware'),
            'prefix' => $this->prefix
        ], function () {
            require __DIR__ . '/routes.php';
        });
    }


}

