<?php

namespace App\Providers;

use App\Contracts\Interfaces\AplikasiInterface;
use App\Contracts\Interfaces\FotoAplikasiInterface;
use App\Contracts\Interfaces\KategoriAplikasiInterface;
use App\Contracts\Repositories\AplikasiRepository;
use App\Contracts\Repositories\FotoAplikasiRepository;
use App\Contracts\Repositories\KategoriAplikasiRepository; // <- pastikan ini ada
use Illuminate\Support\ServiceProvider;
use App\Contracts\Interfaces\UserInterface;
use App\Contracts\Repositories\UserRepository; // Perbaiki namespace jadi Repositories (jamak)

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(AplikasiInterface::class, AplikasiRepository::class);

        // Binding interface KategoriAplikasi ke repository, bukan controller
        $this->app->bind(
            \App\Contracts\Interfaces\KategoriInterface::class,
            \App\Repositories\KategoriRepository::class
        );

        $this->app->bind(FotoAplikasiInterface::class, FotoAplikasiRepository::class);

        $this->app->bind(UserInterface::class, UserRepository::class);

        $this->app->bind(
            \App\Contracts\Interfaces\FotoBeritaInterface::class,
            \App\Contracts\Repositories\FotoBeritaRepository::class
        );
        $this->app->bind(
            \App\Contracts\Interfaces\BeritaInterface::class,
            \App\Contracts\Repositories\BeritaRepository::class
        );
        
        // Tambahkan binding lain jika perlu
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
