<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's route middleware.
     *
     * @var array
     */
    protected $middlewareAliases = [
        'admin' => \App\Http\Middleware\Admin::class,
        // ... other middleware entries
    ];
}