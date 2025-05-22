<?php

use App\Http\Controllers\KategoriAplikasiController;
use App\Http\Controllers\KategoriController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\AplikasiController;
use App\Http\Controllers\SearchController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Rute utama
Route::get('/', function () {
    return view('dashboard');
});

// Rute dashboard (hanya bisa diakses jika login & verifikasi)
Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::get('/aplikasi', function () {
    return view('aplikasi.index');
})->name('aplikasi');

// Rute Login via Google
Route::get('/login/google', [GoogleController::class, 'redirect'])->name('google.redirect');
Route::get('/login/google/callback', [GoogleController::class, 'callback'])->name('google.callback');

// Rute Register (tampilan dan proses)
Route::get('/register', [RegisteredUserController::class, 'create'])
    ->middleware('guest')
    ->name('register');
Route::post('/register', [RegisteredUserController::class, 'store'])
    ->middleware('guest');

// Rute untuk profile user (hanya jika login)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Rute untuk Kategori
Route::get('/kategori', [KategoriController::class, 'index'])->name('kategori.index');

Route::get('/kategori/permainan', [KategoriController::class, 'permainan'])->name('kategori.permainan');
Route::get('/kategori/kesehatan', [KategoriController::class, 'kesehatan'])->name('kategori.kesehatan');
Route::get('/kategori/fashion', [KategoriController::class, 'fashion'])->name('kategori.fashion');
Route::get('/kategori/olahraga', [KategoriController::class, 'olahraga'])->name('kategori.olahraga');
Route::get('/kategori/pendidikan', [KategoriController::class, 'pendidikan'])->name('kategori.pendidikan');
Route::get('/kategori/belanja', [KategoriController::class, 'belanja'])->name('kategori.belanja');



Route::get('/aplikasi/populer', function () {
    return view('aplikasi.populer');
});

Route::get('/aplikasi/detail', function () {
    return view('aplikasi.detail');
})->name('aplikasi.detail');
// Route::get('/aplikasi/detail', [AplikasiController::class, 'detail'])->name('aplikasi.detail');



Route::get('/search', function () {
    return view('aplikasi.search');
})->name('search');
// Rute auth dari Laravel Breeze (login, logout, password reset, dll)
require __DIR__.'/auth.php';
