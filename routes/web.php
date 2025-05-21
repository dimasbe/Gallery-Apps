<?php

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

Route::get('/aplikasi/detail', function () {
    return view('aplikasi.detail');
});

// Rute search (Pilih salah satu)
// Route::get('/search', [AplikasiController::class, 'index'])->name('search');
Route::get('/search', function () {
    return view('aplikasi.search');
})->name('search');


Route::prefix('kategori')->group(function () {
    Route::view('/permainan', 'kategori.permainan')->name('kategori.permainan');
    Route::view('/kesehatan', 'kategori.kesehatan')->name('kategori.kesehatan');
    Route::view('/fashion', 'kategori.fashion')->name('kategori.fashion');
    Route::view('/olahraga', 'kategori.olahraga')->name('kategori.olahraga');
    Route::view('/pendidikan', 'kategori.pendidikan')->name('kategori.pendidikan');
    Route::view('/belanja', 'kategori.belanja')->name('kategori.belanja');
});

// Rute auth dari Laravel Breeze
require __DIR__.'/auth.php';
