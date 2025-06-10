<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NotificationController;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\AplikasiController;
use App\Http\Controllers\Pengguna\KategoriController; // Jika ini untuk kategori umum, bukan aplikasi
use App\Http\Controllers\Admin\AdminBeritaController;
use App\Http\Controllers\BeritaController;
use App\Models\Berita; // Penting: Import model Berita untuk mengakses data
use App\Models\Kategori; // PASTIKAN KATEGORI DI-IMPORT UNTUK APLIKASI CONTROLLER


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

// 🏠 Rute utama (root) - Mengarahkan user yang sudah login, ATAU menampilkan homepage dengan berita terbaru
Route::get('/', function () {
    if (Auth::check()) {
        if (Auth::user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        } else {
            return redirect()->route('dashboard');
        }
    }
    // Jika user belum login, panggil metode controller untuk menampilkan homepage dengan berita terbaru
    return app(BeritaController::class)->homepageLatestNews();
})->name('welcome');

// 📊 Dashboard user biasa (memerlukan autentikasi dan verifikasi email)
// Rute ini sekarang mengambil data berita dan mengirimkannya ke view
Route::get('/dashboard', function () {
    // Jika user adalah admin, alihkan ke dashboard admin
    if (Auth::check() && Auth::user()->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }

    // Ambil 3 berita terbaru dari database
    // Pastikan model Berita Anda sudah benar dan memiliki kolom 'tanggal_dibuat'
    $beritas = Berita::orderBy('tanggal_dibuat', 'desc')->limit(3)->get();

    // Kirim variabel $beritas ke view 'dashboard'
    return view('dashboard', compact('beritas'));
})->middleware(['auth', 'verified'])->name('dashboard');


// --- PERBAIKAN DAN PENAMBAHAN DI SINI ---

// Rute untuk Halaman Aplikasi Umum (misalnya, semua aplikasi atau halaman utama aplikasi)
Route::get('/aplikasi', [AplikasiController::class, 'index'])->name('aplikasi');

// Rute untuk detail aplikasi (penting untuk tautan di hasil pencarian dan halaman aplikasi)
// Rute ini menerima ID aplikasi dan memanggil metode 'detail' di AplikasiController
Route::get('/aplikasi/detail/{aplikasi}', [AplikasiController::class, 'detail'])->name('aplikasi.detail');

// Rute BARU untuk Aplikasi Paling Populer - Mengarahkan ke metode 'showPopuler' di AplikasiController
Route::get('/aplikasi/populer', [AplikasiController::class, 'showPopuler'])->name('aplikasi.populer');

// Rute untuk menampilkan aplikasi berdasarkan kategori
// Menggunakan wildcard {nama_kategori} yang akan ditangkap oleh controller
Route::get('/kategori-aplikasi/{nama_kategori}', [AplikasiController::class, 'showByCategory'])->name('kategori.show');


// --- AKHIR PERBAIKAN DAN PENAMBAHAN ---


// 🔐 Login via Google (untuk user biasa)
Route::get('/login/google', [GoogleController::class, 'redirect'])->name('google.redirect');
Route::get('/login/google/callback', [GoogleController::class, 'callback'])->name('google.callback');


// 📝 Register (untuk user biasa)
Route::get('/register', [RegisteredUserController::class, 'create'])
    ->middleware('guest')
    ->name('register');
Route::post('/register', [RegisteredUserController::class, 'store'])
    ->middleware('guest');


// 👤 Profile user (hanya untuk user yang sudah login)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


// Rute kategori umum (ini berbeda dengan kategori aplikasi di atas)
// Jika Anda memiliki KategoriController terpisah untuk hal-hal selain aplikasi, ini adalah tempatnya.
// Perhatikan nama route-nya agar tidak konflik.
Route::get('/kategori', [KategoriController::class, 'index'])->name('kategori.index_umum');
Route::get('/kategori/{nama}', [KategoriController::class, 'showByNama'])->name('kategori.show_umum');


// Rute search
Route::get('/search', [AplikasiController::class, 'search'])->name('search');

// Rute Berita (public)
Route::get('/berita', [BeritaController::class, 'index'])->name('berita.index');
Route::get('/berita/{id}', [BeritaController::class, 'show'])->name('berita.show');

// Rute Admin Berita (untuk CKEditor upload)
Route::post('/admin/berita/upload-ckeditor-image', [AdminBeritaController::class, 'uploadCkeditorImage'])->name('admin.berita.uploadCkeditorImage');


require __DIR__.'/auth.php';
require __DIR__.'/user_login.php';

Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');

Route::get('/kategori/{nama}', [KategoriController::class, 'showByNama'])->name('kategori.show_by_nama');