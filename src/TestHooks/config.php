<?php

return [
    'middleware' => [\Illuminate\Session\Middleware\StartSession::class, \dam1r89\TestHooks\Http\Middleware\TestEnvMiddleware::class],
    'env' => ['local', 'testing']
];
