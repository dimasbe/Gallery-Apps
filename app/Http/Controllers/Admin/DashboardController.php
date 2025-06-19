<?php

namespace App\Http\Controllers\Admin;

use App\Contracts\Interfaces\AplikasiInterface;
use App\Contracts\Interfaces\UserInterface;
use App\Contracts\Interfaces\KategoriInterface;
use App\Http\Controllers\Controller;
use App\Models\Aplikasi;
use App\Models\Berita;
use App\Models\Kategori;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Menampilkan halaman dashboard admin dengan data awal.
     */
    public function index(): View
    {
        // Statistik Dashboard Umum
        $totalUsers = User::count();
        $totalAplikasiDiunggah = Aplikasi::count();

        // Ambil bulan dan tahun saat ini sebagai default
        $year = now()->year;
        $month = now()->month;

        // Panggil metode getDashboardDataInternal untuk mendapatkan data awal
        $initialData = $this->getDashboardDataInternal($month, $year);

        // Data Kategori (ini bisa tetap statis atau disesuaikan jika perlu difilter bulanan)
        // Kita akan menggunakan ini untuk label dataset di chart bulanan, jadi cukup ambil semua
        $kategoriAplikasi = Kategori::where('sub_kategori', 'aplikasi')->get();

        // Generate dynamic months for dropdowns (ini tetap di index karena untuk dropdown HTML)
        $months = [];
        $currentMonth = now()->startOfMonth();
        for ($i = 0; $i < 12; $i++) {
            $months[] = [
                'value' => $currentMonth->format('Y-m'),
                'label' => $currentMonth->locale('id')->isoFormat('MMMM YYYY') // Sesuaikan format untuk menampilkan tahun juga
            ];
            $currentMonth->subMonth();
        }
        $months = array_reverse($months); // Urutkan dari bulan terbaru ke terlama

        // Teruskan semua data awal yang diperlukan ke view admin dashboard Anda
        return view('admin.dashboard', compact(
            'totalUsers',
            'totalAplikasiDiunggah',
            'initialData', // Data dinamis yang akan diisi oleh JS
            'kategoriAplikasi', // Data kategori yang akan digunakan oleh JS untuk chart
            'months' // Untuk dropdown filter
        ));
    }

    /**
     * Mengambil data dashboard yang difilter berdasarkan bulan dan tahun via AJAX.
     */
    public function getDashboardData(Request $request): JsonResponse
    {
        $month = $request->query('month');
        $year = $request->query('year');

        // Validasi input bulan dan tahun
        if (!is_numeric($month) || !is_numeric($year) || $month < 1 || $month > 12 || $year < 1900 || $year > 2100) {
            // Berikan nilai default jika input tidak valid
            $month = now()->month;
            $year = now()->year;
        }

        $data = $this->getDashboardDataInternal($month, $year);

        return response()->json($data);
    }

    /**
     * Metode internal untuk mengambil data dashboard yang bisa digunakan oleh index dan getDashboardData.
     * @param int $month
     * @param int $year
     * @return array
     */
    private function getDashboardDataInternal(int $month, int $year): array
    {
        $startDate = Carbon::createFromDate($year, $month, 1)->startOfMonth();
        $endDate = Carbon::createFromDate($year, $month, 1)->endOfMonth();

        // Data untuk "Aplikasi Sering Dikunjungi" (Most Visited Apps)
        $mostVisitedApps = Aplikasi::whereBetween('created_at', [$startDate, $endDate]) // Filter by month of upload/activity
                                       ->with(['fotoAplikasi' => function($query) {
                                           $query->select('id_aplikasi', 'path_foto')->orderBy('created_at', 'asc')->limit(1); // Ambil hanya foto pertama
                                       }])
                                       ->orderBy('jumlah_kunjungan', 'desc')
                                       ->limit(6)
                                       ->get()
                                       ->map(function($app) {
                                           $thumbnailPath = $app->fotoAplikasi->isNotEmpty() ? $app->fotoAplikasi->first()->path_foto : null;
                                           return [
                                               'id' => $app->id,
                                               'nama_aplikasi' => $app->nama_aplikasi,
                                               'nama_pemilik' => $app->nama_pemilik,
                                               // Menggunakan thumbnail_aplikasi untuk gambar cover/utama aplikasi
                                               'thumbnail_aplikasi' => $thumbnailPath ? asset('storage/' . $thumbnailPath) : 'https://placehold.co/40x40/cccccc/333333?text=App',
                                               'total_kunjungan' => $app->jumlah_kunjungan,
                                           ];
                                       });


        // Data untuk "Publisher Terpopuler" (Popular Publishers)
        $popularPublishers = Aplikasi::select('nama_pemilik', DB::raw('MAX(logo) as publisher_logo'), DB::raw('SUM(jumlah_kunjungan) as total_unduhan_apps'))
                                           ->whereBetween('created_at', [$startDate, $endDate]) // Filter by month of upload/activity
                                           ->groupBy('nama_pemilik')
                                           ->orderByDesc('total_unduhan_apps')
                                           ->limit(10)
                                           ->get()
                                           ->map(function($publisher) {
                                               return [
                                                   'nama_pemilik' => $publisher->nama_pemilik,
                                                   'total_unduhan_apps' => $publisher->total_unduhan_apps,
                                                   'publisher_logo' => $publisher->publisher_logo ? asset('storage/' . $publisher->publisher_logo) : 'https://placehold.co/32x32/cccccc/333333?text=P',
                                               ];
                                           });

        // Data untuk "Berita Sering Dilihat" (untuk Grafik Donat)
        $mostViewedNewsForChart = Berita::whereBetween('tanggal_dibuat', [$startDate, $endDate])
                                             ->orderBy('jumlah_kunjungan', 'desc')
                                             ->limit(5)
                                             ->get();

        $newsChartLabels = $mostViewedNewsForChart->pluck('judul_berita')->toArray();
        $newsChartData = $mostViewedNewsForChart->pluck('jumlah_kunjungan')->toArray();
        // Fallback jika tidak ada data kunjungan atau semua nol
        if (empty($newsChartData) || array_sum($newsChartData) === 0) {
            $newsChartData = array_fill(0, count($mostViewedNewsForChart), 1);
        }

        // Data untuk "Berita Terbaru" (Kolom Kanan)
        $latestNews = Berita::whereBetween('tanggal_dibuat', [$startDate, $endDate])
                                ->orderBy('tanggal_dibuat', 'desc')
                                ->limit(5)
                                ->get()
                                ->map(function($berita) {
                                    return [
                                        'id' => $berita->id,
                                        'judul_berita' => $berita->judul_berita,
                                        'tanggal_dibuat' => Carbon::parse($berita->tanggal_dibuat)->locale('id')->isoFormat('D MMMM YYYY') // Ubah format untuk tahun
                                    ];
                                });

        // --- Data Rekap Bulanan berdasarkan Kategori ---
        $monthlyRecapLabels = [];
        $monthlyRecapDatasets = [];
        $daysInMonth = $startDate->daysInMonth;

        // Siapkan label sumbu X (hari dalam bulan)
        for ($i = 0; $i < $daysInMonth; $i++) {
            $day = $startDate->copy()->addDays($i);
            $monthlyRecapLabels[] = $day->isoFormat('D');
        }

        // Ambil semua kategori aplikasi yang aktif atau relevan
        $categories = Kategori::where('sub_kategori', 'aplikasi')->get();

        // Siapkan datasets untuk setiap kategori
        foreach ($categories as $category) {
            $dataForCategory = [];
            for ($i = 0; $i < $daysInMonth; $i++) {
                $day = $startDate->copy()->addDays($i);
                // Hitung jumlah aplikasi yang diunggah pada hari ini untuk kategori tertentu
                $count = Aplikasi::whereDate('created_at', $day->toDateString())
                                 ->where('id_kategori', $category->id) // PASTIKAN NAMA KOLOM INI SESUAI DENGAN DB ANDA
                                 ->count();
                $dataForCategory[] = $count;
            }

            // Tambahkan dataset untuk kategori ini
            // Warna akan di-generate acak di controller, atau bisa didefinisikan di frontend JS
            $monthlyRecapDatasets[] = [
                'label' => $category->nama_kategori,
                'data' => $dataForCategory,
                'backgroundColor' => 'rgba(' . rand(0,255) . ',' . rand(0,255) . ',' . rand(0,255) . ', 0.6)',
                'borderColor' => 'rgba(' . rand(0,255) . ',' . rand(0,255) . ',' . rand(0,255) . ', 1)',
                'borderWidth' => 1,
                'borderRadius' => 5,
            ];
        }

        // Jika tidak ada kategori atau data untuk kategori, tambahkan dataset default
        if ($categories->isEmpty() || empty($monthlyRecapDatasets)) {
             $monthlyRecapDatasets[] = [
                 'label' => 'Tidak Ada Data',
                 'data' => array_fill(0, $daysInMonth, 0),
                 'backgroundColor' => '#CCCCCC',
                 'borderColor' => '#CCCCCC',
                 'borderWidth' => 1,
                 'borderRadius' => 5,
             ];
        }
        // --- Akhir Perubahan Penting ---

        return [
            'totalUsers' => User::count(),
            'totalAplikasiDiunggah' => Aplikasi::count(),
            'mostVisitedApps' => $mostVisitedApps,
            'popularPublishers' => $popularPublishers,
            'newsChart' => [
                'labels' => $newsChartLabels,
                'data' => $newsChartData,
            ],
            'latestNews' => $latestNews,
            'monthlyRecap' => [
                'labels' => $monthlyRecapLabels,
                'datasets' => $monthlyRecapDatasets,
            ]
        ];
    }
}
