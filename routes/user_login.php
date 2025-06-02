<?php

use App\Http\Controllers\TambahAplikasiController;
use Illuminate\Support\Facades\Route;

route::middleware('auth')->prefix('user-login')->group(function (){
    route::get('aplikasi', [TambahAplikasiController::class, 'index'])->name('user_login.aplikasi.index');
    route::get('aplikasi/tambah', [TambahAplikasiController::class, 'create'])->name('user_login.aplikasi.create');
    route::post('aplikasi', [TambahAplikasiController::class, 'store'])->name('user_login.aplikasi.store');
    Route::get('aplikasi/{aplikasi}', [TambahAplikasiController::class, 'show'])->name('user_login.aplikasi.show');
    Route::get('aplikasi/{aplikasi}/edit', [TambahAplikasiController::class, 'edit'])->name('user_login.aplikasi.edit');
    Route::put('aplikasi/{aplikasi}', [TambahAplikasiController::class, 'update'])->name('user_login.aplikasi.update');
    Route::delete('aplikasi/{aplikasi}', [TambahAplikasiController::class, 'destroy'])->name('user_login.aplikasi.destroy');
});