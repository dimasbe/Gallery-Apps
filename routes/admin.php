<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Admin\AdminRegisterController;
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
// Nama rute akan menjadi 'admin.register' karena RouteServiceProvider
Route::get('/register', [AdminRegisterController::class, 'showForm'])->name('register');
Route::post('/register', [AdminRegisterController::class, 'register'])->name('register.store'); // Menambahkan nama untuk rute POST register admin

// Grup Rute Admin yang memerlukan autentikasi DAN memiliki role 'admin'
Route::middleware(['auth', 'admin'])->group(function () {

    // 📊 Dashboard Admin
    // Nama rute akan menjadi 'admin.dashboard' karena RouteServiceProvider
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // ⛔ Logout Admin (dilindungi oleh middleware 'auth')
    // Nama rute akan menjadi 'admin.logout' karena RouteServiceProvider
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

    // Contoh rute lain untuk admin
    // Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
});
