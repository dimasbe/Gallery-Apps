<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// use App\Models\Arsip; // Komen atau hapus ini jika belum ada modelnya

class ArsipController extends Controller
{
    /**
     * Menampilkan daftar arsip.
     */
    public function index(Request $request)
    {
        $arsip = [
            ['nama_aplikasi' => 'Mobile Legend', 'pemilik' => 'Stevia Magdalena', 'kategori' => 'Permainan', 'tanggal' => '06 - 05 - 2025'],
            ['nama_aplikasi' => 'Mobile Legend', 'pemilik' => 'Stevia Magdalena', 'kategori' => 'Permainan', 'tanggal' => '06 - 05 - 2025'],
            ['nama_aplikasi' => 'Mobile Legend', 'pemilik' => 'Stevia Magdalena', 'kategori' => 'Permainan', 'tanggal' => '06 - 05 - 2025'],
            ['nama_aplikasi' => 'Mobile Legend', 'pemilik' => 'Stevia Magdalena', 'kategori' => 'Permainan', 'tanggal' => '06 - 05 - 2025'],
            ['nama_aplikasi' => 'Mobile Legend', 'pemilik' => 'Stevia Magdalena', 'kategori' => 'Permainan', 'tanggal' => '06 - 05 - 2025'],
            ['nama_aplikasi' => 'Mobile Legend', 'pemilik' => 'Stevia Magdalena', 'kategori' => 'Permainan', 'tanggal' => '06 - 05 - 2025'],
            ['nama_aplikasi' => 'Mobile Legend', 'pemilik' => 'Stevia Magdalena', 'kategori' => 'Permainan', 'tanggal' => '06 - 05 - 2025'],
            ['nama_aplikasi' => 'Mobile Legend', 'pemilik' => 'Stevia Magdalena', 'kategori' => 'Permainan', 'tanggal' => '06 - 05 - 2025'],
            ['nama_aplikasi' => 'Mobile Legend', 'pemilik' => 'Stevia Magdalena', 'kategori' => 'Permainan', 'tanggal' => '06 - 05 - 2025'],
            ['nama_aplikasi' => 'Mobile Legend', 'pemilik' => 'Stevia Magdalena', 'kategori' => 'Permainan', 'tanggal' => '06 - 05 - 2025'],
        ];

        return view('admin.arsip.index', compact('arsip'));
    }

    // Seperti sebelumnya, jika Anda menggunakan Route::resource() secara penuh,
    // Anda juga perlu metode create(), store(), show(), edit(), update(), destroy()
    // nanti ketika Anda siap. Untuk sementara, index() sudah cukup.
}