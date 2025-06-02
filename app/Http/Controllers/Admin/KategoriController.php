<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// use App\Models\Kategori; // Komen atau hapus ini jika belum ada modelnya

class KategoriController extends Controller
{
    /**
     * Menampilkan daftar kategori.
     */
    public function index()
    {
        // Cukup kembalikan view.
        // Tidak perlu mengambil data dari database atau menggunakan model Kategori dulu.
        return view('admin.kategori.index'); // <-- Ini yang PENTING: nama view harus sesuai
    }

    // Seperti sebelumnya, jika Anda menggunakan Route::resource() secara penuh,
    // Anda juga perlu metode create(), store(), show(), edit(), update(), destroy()
    // nanti ketika Anda siap. Untuk sementara, index() sudah cukup.
}