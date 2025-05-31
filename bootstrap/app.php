<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Add your route middleware alias here
        $middleware->alias([
            'is_admin' => \App\Http\Middleware\IsAdmin::class, // <-- ADD THIS LINE
        ]);

        // You might also see other middleware configurations here,
        // for example, for web group or global middleware:
        // $middleware->web(append: [
        //     \App\Http\Middleware\ExampleMiddleware::class,
        // ]);
        //
        // $middleware->encryptCookies(except: [
        //     // ...
        // ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();