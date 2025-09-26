<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    // Global HTTP middleware
    protected $middleware = [
    ];

    // Middleware groups for web / api
    protected $middlewareGroups = [
        'web' => [
        ],

        'api' => [
            'throttle:api',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],
    ];

    // Route middleware (applied individually)
    protected $routeMiddleware = [
        'check.dashboard' => \App\Http\Middleware\CheckDashboardPermission::class,
      
    ];
}
