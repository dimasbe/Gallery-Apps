<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to your application's "home" route.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/dashboard';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        $this->routes(function () {
            // Rute untuk API (jika ada)
            /*
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));
            */

            // ==============================================================
            // BLOK INI UNTUK MEMUAT RUTE ADMIN SECARA TERPISAH
            // PENTING: BLOK INI HARUS DIMUAT SEBELUM RUTE WEB
            // Ini akan menerapkan prefix '/admin' dan nama rute 'admin.'
            // ==============================================================
            Route::prefix('admin') // Semua rute di routes/admin.php akan memiliki awalan /admin
                ->name('admin.')   // Semua nama rute di routes/admin.php akan memiliki awalan admin.
                ->middleware('web') // Pastikan middleware 'web' diterapkan untuk sesi dan CSRF
                ->group(base_path('routes/admin.php')); // MEMUAT FILE routes/admin.php

            // Rute Web utama (untuk user biasa)
            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        });
    }
}

