<?php

namespace App\Http\Controllers;

use App\Models\Aplikasi; // Pastikan Anda mengimpor model Aplikasi Anda
use App\Models\Berita;   // Pastikan Anda mengimpor model Berita Anda
use App\Models\Kategori; // Pastikan Anda mengimpor model Kategori Anda
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Menampilkan halaman beranda dengan aplikasi terpopuler, berita terbaru, dan daftar kategori.
     *
     * @return View
     */
    public function index(): View
    {
        // Ambil 6 aplikasi populer berdasarkan jumlah_kunjungan (jumlah kunjungan)
        // Pastikan kolom 'jumlah_kunjungan' ada di tabel 'aplikasi' Anda.
        // Eager load relasi 'fotoAplikasi' untuk mengambil gambar cover dan logo.
        $aplikasiPopuler = Aplikasi::orderBy('jumlah_kunjungan', 'desc')
                                    ->limit(6) // Hanya ambil 6 aplikasi terpopuler
                                    ->with('fotoAplikasi') // Load relasi fotoAplikasi untuk gambar cover
                                    ->get();

        // Ambil 3 berita terbaru berdasarkan tanggal_dibuat
        $beritas = Berita::orderBy('tanggal_dibuat', 'desc')->limit(3)->get();

        // Ambil kategori yang memiliki sub_kategori 'aplikasi'
        // Eager load aplikasi pertama dari setiap kategori, dan fotoAplikasi dari aplikasi tersebut
        $kategoriAplikasi = Kategori::where('sub_kategori', 'aplikasi')
                                    ->with(['aplikasi' => function($query) {
                                        $query->with('fotoAplikasi')->limit(1); // Load hanya 1 aplikasi per kategori
                                    }])
                                    ->get();

        // Teruskan aplikasi populer, berita terbaru, DAN kategori ke view beranda Anda
        return view('welcome', compact('aplikasiPopuler', 'beritas', 'kategoriAplikasi'));
    }
}
