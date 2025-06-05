<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\AplikasiController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\Pengguna\KategoriController;
use App\Http\Controllers\Admin\BeritaController;
use App\Http\Controllers\Admin\AdminBeritaController;
use App\Http\Controllers\BeritaController;
//use App\Http\Controllers\Admin\CKEditorUploadController;

//Route::post('/admin/berita/upload', [CKEditorUploadController::class, 'upload'])->name('admin.berita.upload');


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

// 🏠 Rute utama (root) - Mengarahkan user yang sudah login
Route::get('/', function () {
    if (Auth::check()) {
        if (Auth::user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        } else {
            return redirect()->route('dashboard');
        }
    }
    return view('welcome');
})->name('welcome');


// 📊 Dashboard user biasa (memerlukan autentikasi dan verifikasi email)
Route::get('/dashboard', function () {
    if (Auth::check() && Auth::user()->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


// Rute untuk Halaman Aplikasi Umum
Route::get('/aplikasi', function () {
    return view('aplikasi.index');
})->name('aplikasi');

Route::get('/aplikasi/detail', function () {
    return view('aplikasi.detail');
})->name('aplikasi.detail');
Route::get('/aplikasi/populer', function () {
    return view('aplikasi.populer');
})->name('aplikasi.populer');





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


// routes kategori
Route::get('/kategori', [KategoriController::class, 'index'])->name('kategori.index');
Route::get('/kategori/{nama}', [KategoriController::class, 'showByNama'])->name('kategori.show');



Route::get('/aplikasi/populer', function () {
    return view('aplikasi.populer');
});


//Route::middleware(['auth'])->group(function () {
   // Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    //Route::post('/notifications/{notification}/read', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');
//});

// Rute search (Pilih salah satu)
// Route::get('/search', [AplikasiController::class, 'index'])->name('search');

Route::get('/aplikasi/detail', function () {
    return view('aplikasi.detail');
})->name('aplikasi.detail');
// Route::get('/aplikasi/detail', [AplikasiController::class, 'detail'])->name('aplikasi.detail');

Route::get('/search', [AplikasiController::class, 'search'])->name('search');
   
Route::get('/berita', [BeritaController::class, 'index'])->name('berita.index');
Route::get('/berita/{id}', [BeritaController::class, 'show'])->name('berita.show');

//Route::post('/berita/upload-ckeditor-image', [App\Http\Controllers\Admin\BeritaController::class, 'uploadCkeditorImage'])->name('admin.berita.uploadCkeditorImage');
Route::post('/admin/berita/upload-ckeditor-image', [AdminBeritaController::class, 'uploadCkeditorImage'])->name('admin.berita.uploadCkeditorImage');


require __DIR__.'/auth.php';
require __DIR__.'/user_login.php';