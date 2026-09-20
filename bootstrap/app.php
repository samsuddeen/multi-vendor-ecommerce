<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        then: function()
        {
            Route::middleware('web')
            ->prefix('admin')
            ->name('admin.')
            ->group(base_path('routes/admin.php'));

            Route::middleware('web')
            ->prefix('vendor')
            ->name('vendor.')
            ->group(base_path('routes/vendor.php'));

            Route::middleware('web')
            ->prefix('customer')
            ->name('customer.')
            ->group(base_path('routes/customer.php'));
        },

    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'admin.auth' =>\App\Http\Middleware\AdminAuthenticate::class,
            'admin.guest' =>\App\Http\Middleware\AdminGuest::class,

            'vendor.auth' =>\App\Http\Middleware\VendorAuthenticate::class,
            'vendor.guest' =>\App\Http\Middleware\VendorGuest::class,

            'customer.auth' =>\App\Http\Middleware\CustomerAuthenticate::class,
            'customer.guest' =>\App\Http\Middleware\CustomerGuest::class,

        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
