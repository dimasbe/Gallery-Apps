<?php

namespace App\Providers;

use App\Contracts\Interfaces\AplikasiInterface;
use App\Contracts\Interfaces\FotoAplikasiInterface;
use App\Contracts\Interfaces\KategoriInterface;
use App\Contracts\Repositories\AplikasiRepository;
use App\Contracts\Repositories\FotoAplikasiRepository;
use App\Contracts\Repositories\KategoriRepository; 
use Illuminate\Support\ServiceProvider;
use App\Contracts\Interfaces\UserInterface;
use App\Contracts\Repositories\UserRepository;
use App\Contracts\Repository\UserRepository as RepositoryUserRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(AplikasiInterface::class, AplikasiRepository::class);

        $this->app->bind(KategoriInterface::class, KategoriRepository::class);
        // ... other bindings

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
