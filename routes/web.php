<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\AplikasiController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\KategoriAplikasiController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

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


// Rute untuk Kategori
Route::get('/kategori', [KategoriController::class, 'index'])->name('kategori.index');
Route::get('/kategori/{slug}', [KategoriController::class, 'show'])->name('kategori.show');


// Rute search (contoh)
Route::get('/search', function () {
    return view('aplikasi.search');
})->name('search');


require __DIR__.'/auth.php';