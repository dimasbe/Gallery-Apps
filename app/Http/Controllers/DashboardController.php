<?php

namespace App\Http\Controllers;

use App\Models\Aplikasi; // Pastikan Anda mengimpor model Aplikasi Anda
use App\Models\Berita;   // Pastikan Anda mengimpor model Berita Anda
use App\Models\Kategori; // Pastikan Anda mengimpor model Kategori Anda
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Menampilkan halaman dashboard dengan data yang relevan untuk pengguna terautentikasi.
     * Sekarang akan menampilkan aplikasi terpopuler, berita terbaru, dan daftar kategori.
     *
     * @return View
     */
    public function index(): View
    {
        // Ambil 6 aplikasi populer berdasarkan jumlah_kunjungan
        $aplikasiPopuler = Aplikasi::orderBy('jumlah_kunjungan', 'desc')
                                    ->limit(6)
                                    ->with('fotoAplikasi')
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

        // Teruskan aplikasi populer, berita terbaru, DAN kategori ke view dashboard Anda
        return view('dashboard', compact('aplikasiPopuler', 'beritas', 'kategoriAplikasi'));
    }
}
