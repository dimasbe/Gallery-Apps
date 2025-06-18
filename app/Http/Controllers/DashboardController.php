<?php

namespace App\Http\Controllers;

use App\Models\Aplikasi;
use App\Models\Berita;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Menampilkan halaman dashboard dengan data yang relevan untuk pengguna terautentikasi.
     * Menampilkan aplikasi populer, berita terbaru, dan kategori aplikasi.
     *
     * @return View
     */
    public function index(): View
    {
        // Ambil 6 aplikasi populer berdasarkan jumlah_kunjungan
        $aplikasiPopuler = Aplikasi::orderBy('jumlah_kunjungan', 'desc')
            ->where('status_verifikasi', 'diterima')
            ->where('arsip', '0')
            ->limit(6)
            ->with('fotoAplikasi')
            ->get();

        // Ambil 3 berita terbaru berdasarkan tanggal_dibuat
        $beritas = Berita::orderBy('tanggal_dibuat', 'desc')->limit(3)->get();

        // Ambil kategori yang memiliki sub_kategori 'aplikasi'
        // Eager load aplikasi pertama dari setiap kategori, dan fotoAplikasi dari aplikasi tersebut
        $kategoriAplikasi = Kategori::where('sub_kategori', 'aplikasi')
            ->with(['aplikasi' => function ($query) {
                $query->with('fotoAplikasi')->limit(1);
            }])
            ->get();

        // Teruskan data ke view dashboard
        return view('dashboard', compact('aplikasiPopuler', 'beritas', 'kategoriAplikasi'));
    }
}


