<?php

return [
    'middleware' => ['web', \dam1r89\TestHooks\Http\Middleware\TestEnvMiddleware::class],
    'env' => ['local', 'testing']
];
