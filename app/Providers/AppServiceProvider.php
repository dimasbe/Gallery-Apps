<?php

namespace App\Providers;

use App\Contracts\Interfaces\AplikasiInterface;
use App\Contracts\Interfaces\FotoAplikasiInterface;
use App\Contracts\Interfaces\KategoriAplikasiInterface;
use App\Contracts\Repositories\AplikasiRepository;
use App\Contracts\Repositories\FotoAplikasiRepository;
use Illuminate\Support\ServiceProvider;
use App\Contracts\Interfaces\UserInterface;

// --- KOREKSI USE STATEMENT DI SINI ---
use App\Http\Controllers\KategoriAplikasiController; // Path untuk Controller
use App\Contracts\Repository\UserRepository;       // <-- Path yang sudah diperbaiki
// --- AKHIR KOREKSI ---

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(AplikasiInterface::class, AplikasiRepository::class);

        // CATATAN PENTING:
        // Anda mengikat KategoriAplikasiInterface ke KategoriAplikasiController.
        // Umumnya, sebuah INTERFACE diikat ke sebuah IMPLEMENTASI (seperti Repository atau Service),
        // BUKAN ke sebuah CONTROLLER. Controller seharusnya MENGGUNAKAN Interface tersebut.
        //
        // Jika KategoriAplikasiInterface adalah untuk repository, Anda kemungkinan besar perlu:
        // 1. Membuat kelas 'KategoriAplikasiRepository' yang mengimplementasikan KategoriAplikasiInterface.
        // 2. Mengubah binding di bawah menjadi:
        //    $this->app->bind(KategoriAplikasiInterface::class, \App\Contracts\Repositories\KategoriAplikasiRepository::class);
        //    (sesuaikan namespace 'Repositories' jika berbeda).
        //
        // Untuk saat ini, kode ini sudah benar secara sintaksis dan tidak akan menimbulkan error
        // "Undefined type", tetapi pertimbangkan kembali desain ini.
        $this->app->bind(KategoriAplikasiInterface::class, KategoriAplikasiController::class);

        $this->app->bind(FotoAplikasiInterface::class, FotoAplikasiRepository::class);

        // Binding untuk User
        $this->app->bind(UserInterface::class, UserRepository::class);

        // Tambahkan binding lainnya jika kamu punya, misal:
        // $this->app->bind(AdminInterface::class, AdminRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}