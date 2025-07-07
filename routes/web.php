<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NotificationController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\AplikasiController;
use App\Http\Controllers\Pengguna\KategoriController;
use App\Http\Controllers\Admin\AdminBeritaController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Middleware\UserMiddleware;
use App\Models\Berita;
use App\Models\Kategori;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route untuk halaman beranda utama (saat belum login)
Route::get('/', function () {
    if (Auth::check()) {
        if (Auth::user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        } else {
            return redirect()->route('dashboard');
        }
    }
    // Jika belum login, tampilkan halaman welcome melalui HomeController
    return app(HomeController::class)->index();
})->name('welcome');

// Route Dashboard untuk pengguna yang sudah login (non-admin)
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified', UserMiddleware::class])->name('dashboard');

// --- START: ROUTES YANG TIDAK MEMERLUKAN AUTENTIKASI ---

// Route Aplikasi (sekarang bisa diakses tanpa login)
Route::get('/aplikasi', [AplikasiController::class, 'index'])->name('aplikasi');
Route::get('/aplikasi/detail/{aplikasi}', [AplikasiController::class, 'showAplikasi'])->name('aplikasi.detail');
Route::get('/aplikasi/populer', [AplikasiController::class, 'showPopuler'])->name('aplikasi.populer');
Route::get('/search', [AplikasiController::class, 'search'])->name('search');

// Route Kategori (sekarang bisa diakses tanpa login)
Route::get('/kategori', [KategoriController::class, 'index'])->name('kategori.index_umum');
// Route Model Binding berdasarkan ID untuk detail kategori aplikasi
Route::get('/kategori-aplikasi/{kategori}', [AplikasiController::class, 'showByCategory'])->name('kategori.show');
// Route khusus untuk detail kategori umum yang mungkin masih menggunakan 'nama'
Route::get('/kategori/{nama}', [KategoriController::class, 'showByNama'])->name('kategori.show_umum');

// Route Berita (sekarang bisa diakses tanpa login)
Route::get('/berita', [BeritaController::class, 'index'])->name('berita.index');
Route::get('/berita/{id}', [BeritaController::class, 'show'])->name('berita.show');

// --- END: ROUTES YANG TIDAK MEMERLUKAN AUTENTIKASI ---


//Route Autentikasi
Route::get('/login/google', [GoogleController::class, 'redirect'])->name('google.redirect');
Route::get('/login/google/callback', [GoogleController::class, 'callback'])->name('google.callback');

Route::get('/register', [RegisteredUserController::class, 'create'])
    ->middleware('guest')
    ->name('register');
Route::post('/register', [RegisteredUserController::class, 'store'])
    ->middleware('guest');

//Route Profile (tetap memerlukan autentikasi)
Route::middleware(['auth', 'verified', UserMiddleware::class])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

//Route Tambahan (dari file terpisah)
require __DIR__.'/auth.php';
require __DIR__.'/user_login.php';

//Route Notifikasi (tetap memerlukan autentikasi)
Route::middleware(['auth', 'verified', UserMiddleware::class])->group(function () {
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');
});

// Route untuk upload gambar CKEditor (biasanya untuk admin, jadi tetap dipertahankan tanpa middleware khusus di sini,
// tapi pastikan ada middleware di controller jika hanya admin yang boleh mengunggah)
Route::post('/admin/berita/upload-ckeditor-image', [AdminBeritaController::class, 'uploadCkeditorImage'])->name('admin.berita.uploadCkeditorImage');