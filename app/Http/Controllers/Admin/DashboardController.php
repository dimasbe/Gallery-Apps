<?php
namespace App\Http\Controllers\Admin; // Namespace ini harus menjadi baris pertama setelah tag pembuka PHP

use App\Http\Controllers\Controller;
use App\Models\Aplikasi;
use App\Models\Berita;
use App\Models\Kategori;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(): View
    {
        // Statistik Dashboard Umum
        $totalUsers = User::count();
        $totalAplikasiDiunggah = Aplikasi::count();

        // Data untuk "Aplikasi Sering Dikunjungi" (Most Visited Apps)
        $mostVisitedApps = Aplikasi::orderBy('jumlah_kunjungan', 'desc')
                                    ->limit(6) // Ambil 6 aplikasi teratas
                                    ->with('fotoAplikasi') // Load fotoAplikasi untuk ikon
                                    ->get();

        // Data untuk "Publisher Terpopuler" (Popular Publishers)
        // Menjumlahkan jumlah_kunjungan dari semua aplikasi per pemilik DAN mengambil satu logo
        $popularPublishers = Aplikasi::select('nama_pemilik', DB::raw('MAX(logo) as publisher_logo'), DB::raw('SUM(jumlah_kunjungan) as total_unduhan_apps'))
                                     ->groupBy('nama_pemilik')
                                     ->orderByDesc('total_unduhan_apps')
                                     ->limit(10) // Ambil 10 publisher teratas
                                     ->get();

        // Data untuk "Berita Sering Dilihat" (untuk Grafik Donat)
        $mostViewedNewsForChart = Berita::orderBy('tanggal_dibuat', 'desc')
                                         ->limit(5)
                                         ->get();

        $newsChartLabels = $mostViewedNewsForChart->pluck('judul_berita')->toArray();
        $newsChartData = $mostViewedNewsForChart->pluck('jumlah_kunjungan')->toArray();
        if (empty($newsChartData) || array_sum($newsChartData) === 0) {
             $newsChartData = array_fill(0, count($mostViewedNewsForChart), 1);
        }

        // Data untuk "Berita Terbaru" (Kolom Kanan)
        $beritas = Berita::orderBy('tanggal_dibuat', 'desc')->limit(5)->get();

        // Data Kategori untuk filter di bawah grafik bulanan
        $kategoriAplikasi = Kategori::where('sub_kategori', 'aplikasi')
                                    ->with(['aplikasi' => function($query) {
                                        $query->with('fotoAplikasi')->limit(1);
                                    }])
                                    ->get();

        // Generate dynamic months for dropdowns
        $months = [];
        $currentMonth = now()->startOfMonth(); // Mengambil bulan dan tahun saat ini
        for ($i = 0; $i < 12; $i++) { // Mengulang untuk 12 bulan terakhir
            $months[] = [
                'value' => $currentMonth->format('Y-m'), // Contoh: "2025-06"
                'label' => $currentMonth->locale('id')->isoFormat('MMMM YYYY') // PASTIKAN FORMAT INI BENAR UNTUK INDONESIA
            ];
            $currentMonth->subMonth(); // Mundur ke bulan sebelumnya
        }
        $months = array_reverse($months); // Urutkan dari bulan terbaru ke terlama

        // Teruskan semua data ke view admin dashboard Anda
        return view('admin.dashboard', compact(
            'totalUsers',
            'totalAplikasiDiunggah',
            'mostVisitedApps',
            'popularPublishers',
            'newsChartLabels',
            'newsChartData',
            'beritas',
            'kategoriAplikasi',
            'mostViewedNewsForChart',
            'months' // Meneruskan variabel bulan yang sudah dinamis
        ));
    }
}
