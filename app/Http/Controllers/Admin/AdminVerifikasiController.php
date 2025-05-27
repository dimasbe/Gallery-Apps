<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminVerifikasiController extends Controller
{
    /**
     * Menampilkan halaman verifikasi.
     */
    public function index(Request $request)
    {
        $verifikasiData = [
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

        return view('admin.verifikasi.index', compact('verifikasiData'));
    }
}