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
use App\Models\Berita;
use App\Models\Kategori; // Pastikan ini diimpor jika digunakan di route

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

// Rute untuk halaman beranda utama (saat belum login)
Route::get('/', function () {
    if (Auth::check()) {
        if (Auth::user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        } else {
            return redirect()->route('dashboard'); // Arahkan ke dashboard jika sudah login (non-admin)
        }
    }
    // Jika belum login, tampilkan halaman welcome melalui HomeController
    return app(HomeController::class)->index(); // Panggil metode index() dari HomeController
})->name('welcome');

// Rute Dashboard untuk pengguna yang sudah login (non-admin)
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

// --- Rute Aplikasi ---
Route::get('/aplikasi', [AplikasiController::class, 'index'])->name('aplikasi');
// Route Model Binding berdasarkan ID untuk detail aplikasi
Route::get('/aplikasi/detail/{aplikasi}', [AplikasiController::class, 'showAplikasi'])->name('aplikasi.detail');
Route::get('/aplikasi/populer', [AplikasiController::class, 'showPopuler'])->name('aplikasi.populer');
Route::get('/search', [AplikasiController::class, 'search'])->name('search');

// --- Rute Kategori (Umum & Detail) ---
Route::get('/kategori', [KategoriController::class, 'index'])->name('kategori.index_umum');
// Route Model Binding berdasarkan ID untuk detail kategori aplikasi
// Parameter {kategori} akan otomatis mengikat ke instance model Kategori berdasarkan ID
Route::get('/kategori-aplikasi/{kategori}', [AplikasiController::class, 'showByCategory'])->name('kategori.show');

// Route khusus untuk detail kategori umum yang mungkin masih menggunakan 'nama'
// Jika ingin ini juga pakai ID/Slug dari model Kategori, pertimbangkan untuk menyatukannya dengan kategori.show
Route::get('/kategori/{nama}', [KategoriController::class, 'showByNama'])->name('kategori.show_umum');


// --- Rute Autentikasi & Profil ---
Route::get('/login/google', [GoogleController::class, 'redirect'])->name('google.redirect');
Route::get('/login/google/callback', [GoogleController::class, 'callback'])->name('google.callback');

Route::get('/register', [RegisteredUserController::class, 'create'])
    ->middleware('guest')
    ->name('register');
Route::post('/register', [RegisteredUserController::class, 'store'])
    ->middleware('guest');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// --- Rute Berita ---
Route::get('/berita', [BeritaController::class, 'index'])->name('berita.index');
Route::get('/berita/{id}', [BeritaController::class, 'show'])->name('berita.show');
Route::post('/admin/berita/upload-ckeditor-image', [AdminBeritaController::class, 'uploadCkeditorImage'])->name('admin.berita.uploadCkeditorImage');

// --- Rute Tambahan (dari file terpisah) ---
require __DIR__.'/auth.php';
require __DIR__.'/user_login.php';

// --- Rute Notifikasi ---
Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');