<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

// Import Interfaces
use App\Contracts\Interfaces\AplikasiInterface;
use App\Contracts\Interfaces\FotoAplikasiInterface;
use App\Contracts\Interfaces\KategoriInterface;
use App\Contracts\Interfaces\UserInterface;
use App\Contracts\Interfaces\BeritaInterface;
use App\Contracts\Interfaces\FotoBeritaInterface;

// Import Repositories
use App\Contracts\Repositories\AplikasiRepository;
use App\Contracts\Repositories\FotoAplikasiRepository;
use App\Contracts\Repositories\UserRepository;
use App\Contracts\Repositories\BeritaRepository;
use App\Contracts\Repositories\FotoBeritaRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(AplikasiInterface::class, AplikasiRepository::class);

        $this->app->bind(KategoriInterface::class, KategoriRepository::class);

        $this->app->bind(FotoAplikasiInterface::class, FotoAplikasiRepository::class);

        $this->app->bind(UserInterface::class, UserRepository::class);

        $this->app->bind(BeritaInterface::class, BeritaRepository::class);

        $this->app->bind(FotoBeritaInterface::class, FotoBeritaRepository::class);


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
