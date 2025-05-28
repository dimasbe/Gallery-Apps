<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Admin\AdminRegisterController;
use App\Http\Controllers\Admin\AdminVerifikasiController;
use App\Http\Controllers\Admin\RiwayatController;
use App\Http\Controllers\Admin\BeritaController;
use App\Http\Controllers\Admin\KategoriController;
use App\Http\Controllers\Admin\ArsipController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| These routes are for the administration panel. They are implicitly prefixed
| with '/admin' and their names with 'admin.' due to RouteServiceProvider.
| Middleware such as 'auth' and your custom 'admin' middleware are applied
| where necessary within this file.
|
| PENTING: Awalan 'admin.' untuk nama rute sudah ditangani di RouteServiceProvider.
|           Jadi, di sini kita hanya perlu nama rute tanpa awalan 'admin.'.
*/

// Rute Login Admin (tidak dilindungi middleware 'auth' atau 'admin' agar bisa diakses untuk login)
// Nama rute akan menjadi 'admin.login' dan 'admin.login.store' karena RouteServiceProvider
Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store'])->name('login.store');

// Rute Register Admin (tidak dilindungi middleware 'auth' atau 'admin')
// Nama rute akan menjadi 'admin.register' karena RouteServiceProvider
Route::get('/register', [AdminRegisterController::class, 'showForm'])->name('register');
Route::post('/register', [AdminRegisterController::class, 'register'])->name('register.store'); // Menambahkan nama untuk rute POST register admin

// Grup Rute Admin yang memerlukan autentikasi DAN memiliki role 'admin'
Route::middleware(['auth', 'admin'])->group(function () {

    // 📊 Dashboard Admin
    // Nama rute akan menjadi 'admin.dashboard' karena RouteServiceProvider
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // ⛔ Logout Admin (dilindungi oleh middleware 'auth')
    // Nama rute akan menjadi 'admin.logout' karena RouteServiceProvider
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

    // =============================================================
    //           PERBAIKAN / PENAMBAHAN RUTE DI SINI
    // =============================================================

    // Rute untuk halaman verifikasi
    // Nama rute akan menjadi 'admin.verifikasi'
    Route::get('/verifikasi', [AdminVerifikasiController::class, 'index'])->name('verifikasi');
    Route::post('/admin/aplikasi/{id}/terima', [AdminVerifikasiController::class, 'terima'])->name('admin.aplikasi.terima');
    Route::post('/admin/aplikasi/{id}/tolak', [AdminVerifikasiController::class, 'tolak'])->name('admin.aplikasi.tolak');

    // Rute Resource untuk Riwayat (akan membuat rute seperti admin.riwayat.index, admin.riwayat.show, dll.)
    // Asumsi RiwayatController adalah resource controller
    Route::resource('riwayat', RiwayatController::class)->only(['index', 'show', 'destroy']); // Umumnya riwayat tidak ada create/edit

    // Rute Resource untuk Berita
    // Asumsi BeritaController adalah resource controller
    Route::resource('berita', BeritaController::class);

    // Rute Resource untuk Kategori
    // Asumsi KategoriController adalah resource controller
    Route::resource('kategori', KategoriController::class);

    // Rute Resource untuk Arsip
    // Asumsi ArsipController adalah resource controller
    Route::resource('arsip', ArsipController::class);

    // Anda bisa tambahkan rute-rute admin lainnya di sini
});