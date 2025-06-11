<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Admin\AdminRegisterController;
use App\Http\Controllers\Admin\AdminVerifikasiController;
use App\Http\Controllers\Admin\AdminRiwayatController;
//use App\Http\Controllers\Admin\RiwayatController;
use App\Http\Controllers\Admin\AdminBeritaController;
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
Route::get('/register', [AdminRegisterController::class, 'showForm'])->name('register');
Route::post('/register', [AdminRegisterController::class, 'register'])->name('register.store');

// Grup Rute Admin yang memerlukan autentikasi DAN memiliki role 'admin'
Route::middleware(['auth', 'admin'])->group(function () {

    // 📊 Dashboard Admin
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // ⛔ Logout Admin
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

    // Rute Verifikasi
    Route::get('/verifikasi', [AdminVerifikasiController::class, 'index'])->name('verifikasi');
    
    // Perhatikan prefix /admin sudah otomatis, jadi cukup tulis seperti ini:
    Route::post('/aplikasi/{id}/terima', [AdminVerifikasiController::class, 'terima'])->name('aplikasi.terima');
    Route::post('/aplikasi/{id}/tolak', [AdminVerifikasiController::class, 'tolak'])->name('aplikasi.tolak');

    Route::get('/verifikasi/{id}/detail', [AdminVerifikasiController::class, 'detailVerifikasi'])->name('verifikasi.detail');

    // Jika ingin menampilkan detail aplikasi di riwayat atau sejenisnya:
    Route::get('/aplikasi/{id}', function($id) {
        // Biasanya Anda perlu passing data $id ke view
        return view('admin.riwayat.detail', ['appId' => $id]);
    })->name('aplikasi.show');

    // Resource Controller Berita
    Route::resource('berita', AdminBeritaController::class, [
        'parameters' => [
            'berita' => 'berita'  // agar parameternya {berita}, bukan {beritum}
        ]
    ]);

    // Resource Controller Kategori
    Route::resource('kategori', KategoriController::class);

    // Resource Controller Arsip
    Route::resource('arsip', ArsipController::class);

    // Tambah rute admin lainnya di sini...
    

     // Rute Resource untuk Riwayat (index, show, destroy)
     //Route::resource('riwayat', RiwayatController::class)->only(['index', 'show', 'destroy']);
     //Route::resource('riwayat', RiwayatController::class)->only(['index', 'show', 'destroy'])->names([
        //'index' => 'riwayat.index',   // Akan terdaftar sebagai: 'admin.riwayat.index'
        //'show' => 'riwayat.show',     // Akan terdaftar sebagai: 'admin.riwayat.show'
        //'destroy' => 'riwayat.destroy', // Akan terdaftar sebagai: 'admin.riwayat.destroy'
    //]);
    // Tambahkan rute khusus untuk fungsi 'archive'
    // Pastikan ini ada di dalam group 'admin.' agar namanya menjadi 'admin.riwayat.archive'
    //Route::post('riwayat/{id}/archive', [RiwayatController::class, 'archive'])->name('riwayat.archive');

    // Riwayat (History)
    Route::get('/riwayat', [AdminRiwayatController::class, 'index'])->name('riwayat.index');
    Route::get('/riwayat/{id}/detail', [AdminRiwayatController::class, 'detail'])->name('riwayat.detail');
    Route::delete('/riwayat/{id}/delete', [AdminRiwayatController::class, 'destroy'])->name('riwayat.delete'); 
    Route::put('/riwayat/{id}/archive', [AdminRiwayatController::class, 'archive'])->name('riwayat.archive');

    // Arsip (Archive)
    Route::get('/arsip', [ArsipController::class, 'index'])->name('arsip.index');
    Route::get('/arsip/{id}/show', [ArsipController::class, 'show'])->name('arsip.show'); // Changed from 'detail' to 'show' for consistency
    Route::put('/arsip/{id}/unarchive', [ArsipController::class, 'unarchive'])->name('arsip.unarchive'); // New route for unarchiving
    Route::delete('/arsip/{id}/delete', [ArsipController::class, 'deleteFromArchive'])->name('arsip.delete_from_archive'); // New route for deleting from archive
});
