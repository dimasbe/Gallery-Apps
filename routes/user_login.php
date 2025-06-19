<?php

use App\Http\Controllers\TambahAplikasiController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| User Login Routes
|--------------------------------------------------------------------------
|
| This file is where you can register web routes for your "user_login"
| specific routes. These routes are typically authenticated.
|
*/

Route::prefix('user-login/aplikasi')->name('tambah_aplikasi.')->group(function () {
    Route::get('/', [TambahAplikasiController::class, 'index'])->name('index'); 
    Route::get('/create', [TambahAplikasiController::class, 'create'])->name('create'); 
    Route::post('/', [TambahAplikasiController::class, 'store'])->name('store'); 
    Route::get('/{aplikasi}/edit', [TambahAplikasiController::class, 'edit'])->name('edit');
    Route::put('/{aplikasi}', [TambahAplikasiController::class, 'update'])->name('update');
    Route::delete('/{aplikasi}', [TambahAplikasiController::class, 'destroy'])->name('destroy');
    Route::delete('/{aplikasi}/foto/{fotoId}', [TambahAplikasiController::class, 'destroyFoto'])->name('foto.destroy');
    Route::get('/{aplikasi}', [TambahAplikasiController::class, 'show'])->name('show');
});
