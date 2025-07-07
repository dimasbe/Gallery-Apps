<?php

use App\Http\Controllers\Admin\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Admin\AdminRegisterController;
use App\Http\Controllers\Admin\AdminVerifikasiController;
use App\Http\Controllers\Admin\AdminRiwayatController;
use App\Http\Controllers\Admin\AdminBeritaController;
use App\Http\Controllers\Admin\KategoriController;
use App\Http\Controllers\Admin\ArsipController;
//use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;

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

// Route Login Admin
Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store'])->name('login.store');

// Route Register Admin
Route::get('/register', [AdminRegisterController::class, 'showForm'])->name('register');
Route::post('/register', [AdminRegisterController::class, 'register'])->name('register.store');

Route::middleware(['auth', 'admin'])->group(function () {
    // Route Dashboard Admin
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Route endpoint AJAX baru untuk mengambil data dashboard yang difilter
     Route::get('/dashboard-data', [DashboardController::class, 'getDashboardData'])->name('dashboard.data');
     
    // Route Logout Admin
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

    // Route Verifikasi Admin
    Route::get('/verifikasi', [AdminVerifikasiController::class, 'index'])->name('verifikasi');
    
    Route::post('/aplikasi/{id}/terima', [AdminVerifikasiController::class, 'terima'])->name('aplikasi.terima');
    Route::post('/aplikasi/{id}/tolak', [AdminVerifikasiController::class, 'tolak'])->name('aplikasi.tolak');

    Route::get('/verifikasi/{id}/detail', [AdminVerifikasiController::class, 'detailVerifikasi'])->name('verifikasi.detail');

    Route::get('/aplikasi/{id}', function($id) {
        return view('admin.riwayat.detail', ['appId' => $id]);
    })->name('aplikasi.show');

    // Route Berita Admin
    Route::resource('berita', AdminBeritaController::class, [
        'parameters' => [
            'berita' => 'berita'
        ]
    ]);

    // Route Kategori Admin
    Route::resource('kategori', KategoriController::class);

    // Route Arsip Admin
    Route::resource('arsip', ArsipController::class);

    // Route Riwayat Admin
    Route::get('/riwayat', [AdminRiwayatController::class, 'index'])->name('riwayat.index');
    Route::get('/riwayat/{id}/detail', [AdminRiwayatController::class, 'detail'])->name('riwayat.detail');
    Route::delete('/riwayat/{id}/delete', [AdminRiwayatController::class, 'destroy'])->name('riwayat.delete');
    Route::put('/riwayat/{id}/archive', [AdminRiwayatController::class, 'archive'])->name('riwayat.archive');

    // Route Arsip Admin
    Route::get('/arsip', [ArsipController::class, 'index'])->name('arsip.index');
    Route::get('/arsip/{id}/show', [ArsipController::class, 'show'])->name('arsip.show');
    Route::put('/arsip/{id}/unarchive', [ArsipController::class, 'unarchive'])->name('arsip.unarchive');
    Route::delete('/arsip/{id}/delete', [ArsipController::class, 'deleteFromArchive'])->name('arsip.delete_from_archive');

    // Ini adalah rute yang Anda miliki sebelumnya untuk chart-data,
    // Kita akan menggantinya dengan '/dashboard-data' yang lebih umum
    // Route::get('admin/dashboard/chart-data', [DashboardController::class, 'getChartData'])->name('admin.dashboard.chart-data');
});