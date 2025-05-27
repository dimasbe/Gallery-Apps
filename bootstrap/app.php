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
        // Ini adalah tempat Anda mendaftarkan middleware

        // Contoh global middleware (seperti yang dulu di $middleware di Kernel.php)
        // $middleware->web(append: [
        //     \App\Http\Middleware\EncryptCookies::class,
        // ]);

        // Contoh route middleware (seperti yang dulu di $routeMiddleware di Kernel.php)
        $middleware->alias([
            'auth' => \App\Http\Middleware\Authenticate::class,
            // 'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class, // Mungkin sudah ada atau perlu ditambahkan
            // 'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class, // Mungkin sudah ada atau perlu ditambahkan

            // >>>>>> INI ADALAH TEMPAT UNTUK MENDAFTARKAN MIDDLEWARE 'admin' ANDA <<<<<<
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();

