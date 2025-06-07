<?php

namespace App\Http\Controllers\Pengguna;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Http\Controllers\Controller;
use App\Contracts\Interfaces\KategoriInterface;
use App\Enums\KategoriTypeEnum;
// use App\Models\Aplikasi; // Tidak perlu lagi jika data aplikasi diambil via relasi di repository

class KategoriController extends Controller
{
    private KategoriInterface $kategori;

    public function __construct(KategoriInterface $kategori)
    {
        $this->kategori = $kategori;
    }

    public function index(): View
    {
        $aplikasiKategoris = $this->kategori->filterBySubKategori(KategoriTypeEnum::APLIKASI->value);

        return view('pengguna.kategori.index', compact('aplikasiKategoris'));
    }

    public function showByNama($nama): View // Ubah return type menjadi View
    {
        // Menggunakan metode repository yang baru untuk mengambil kategori beserta aplikasinya
        $kategori = $this->kategori->getByNameWithAplikasi(urldecode($nama));
        $aplikasi = $kategori->aplikasi; // Ambil aplikasi dari relasi

        // Kemudian kirim data ke view
        return view('pengguna.kategori.show', compact('kategori', 'aplikasi'));
    }
}