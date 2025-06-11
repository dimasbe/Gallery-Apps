<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AplikasiController;
 // <<< PENTING: Gunakan AplikasiController

/*
|--------------------------------------------------------------------------
| User Login Routes
|--------------------------------------------------------------------------
|
| This file is where you can register web routes for your "user_login"
| specific routes. These routes are typically authenticated.
|
*/

// Grup route untuk fitur "Tambah Aplikasi"
// Prefix 'user-login/aplikasi' cocok dengan URL yang Anda lihat di screenshot
// Nama route 'tambah_aplikasi.' juga cocok dengan yang digunakan di Blade Anda.
Route::prefix('user-login/aplikasi')->name('tambah_aplikasi.')->group(function () {
    Route::get('/', [AplikasiController::class, 'indexPage'])->name('index'); // Misalnya daftar aplikasi
    Route::get('/create', [AplikasiController::class, 'create'])->name('create'); // Form tambah
    Route::post('/', [AplikasiController::class, 'store'])->name('store'); // <<< PENTING: Route POST untuk menyimpan
    Route::get('/{aplikasi}/edit', [AplikasiController::class, 'edit'])->name('edit');
    Route::put('/{aplikasi}', [AplikasiController::class, 'update'])->name('update');
    Route::delete('/{aplikasi}', [AplikasiController::class, 'destroy'])->name('destroy');
    Route::get('/{aplikasi}', [AplikasiController::class, 'show'])->name('show'); // Untuk detail jika ada
    // Anda bisa tambahkan route search jika diperlukan, misal:
    // Route::get('/search', [AplikasiController::class, 'search'])->name('search');
});
