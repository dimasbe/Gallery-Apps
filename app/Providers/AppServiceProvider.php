<?php

namespace App\Providers;

use App\Contracts\Interfaces\UlasanInterface;
use App\Contracts\Repositories\UlasanRepository;
use App\Models\Notifikasi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

// Import Interfaces Anda (Hanya Repository Interface)
use App\Contracts\Interfaces\AplikasiInterface;
use App\Contracts\Interfaces\FotoAplikasiInterface;
use App\Contracts\Interfaces\KategoriInterface;
use App\Contracts\Interfaces\UserInterface;
use App\Contracts\Interfaces\BeritaInterface;
use App\Contracts\Interfaces\FotoBeritaInterface;
use App\Contracts\Interfaces\NotifikasiInterface;
use App\Contracts\Interfaces\VerifikasiAplikasiInterface;

// Import Repositories dan Services Anda (Class Konkret Service)
use App\Contracts\Repositories\AplikasiRepository;
use App\Contracts\Repositories\FotoAplikasiRepository;
use App\Contracts\Repositories\UserRepository;
use App\Contracts\Repositories\BeritaRepository;
use App\Contracts\Repositories\FotoBeritaRepository;
use App\Contracts\Repositories\KategoriRepository;
use App\Contracts\Repositories\VerifikasiAplikasiRepository;
use App\Contracts\Repositories\NotifikasiRepository;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Binding untuk Repository
        $this->app->bind(AplikasiInterface::class, AplikasiRepository::class);
        $this->app->bind(KategoriInterface::class, KategoriRepository::class);
        $this->app->bind(FotoAplikasiInterface::class, FotoAplikasiRepository::class);
        $this->app->bind(UserInterface::class, UserRepository::class);
        $this->app->bind(BeritaInterface::class, BeritaRepository::class);
        $this->app->bind(FotoBeritaInterface::class, FotoBeritaRepository::class);
        $this->app->bind(VerifikasiAplikasiInterface::class, VerifikasiAplikasiRepository::class);
        $this->app->bind(NotifikasiInterface::class, NotifikasiRepository::class);
        $this->app->bind(UlasanInterface::class, UlasanRepository::class);

        // ... (binding lain jika ada)
    }

    public function boot(): void
    {
        View::composer('layouts.app', function ($view) {
            $user = Auth::user();

            if($user) {
                $notifications = Notifikasi::where('user_id', $user->id)
                                        ->orderBy('created_at', 'desc')
                                        ->get();
                $view->with('notifications', $notifications);
            }
            else
            {
                $view->with('notifications', collect());
            }
        });
        
        Paginator::useTailwind();
        
        // 
        // if (env('APP_ENV') === 'production' || str_contains(env('APP_URL'), 'ngrok-free.app')) {
            //URL::forceScheme('https');
        // }
    }
}