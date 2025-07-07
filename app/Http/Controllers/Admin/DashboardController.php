<?php

namespace App\Http\Controllers\Admin;

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
    public function index(): View
    {
        $totalUsers = User::count();
        $totalAplikasiDiunggah = Aplikasi::count();

        $year = now()->year;
        $month = now()->month;

        $initialData = $this->getDashboardDataInternal($month, $year);
        $kategoriAplikasi = Kategori::where('sub_kategori', 'aplikasi')->get();

        $months = [];
        $currentMonth = now()->startOfMonth();
        for ($i = 0; $i < 12; $i++) {
            $months[] = [
                'value' => $currentMonth->format('Y-m'),
                'label' => $currentMonth->locale('id')->isoFormat('MMMM YYYY')
            ];
            $currentMonth->subMonth();
        }
        $months = array_reverse($months);

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalAplikasiDiunggah',
            'initialData',
            'kategoriAplikasi',
            'months'
        ));
    }

    public function getDashboardData(Request $request): JsonResponse
    {
        $month = $request->query('month');
        $year = $request->query('year');

        if (!is_numeric($month) || !is_numeric($year) || $month < 1 || $month > 12 || $year < 1900 || $year > 2100) {
            $month = now()->month;
            $year = now()->year;
        }

        $data = $this->getDashboardDataInternal($month, $year);
        return response()->json($data);
    }

    private function getDashboardDataInternal(int $month, int $year): array
    {
        $startDate = Carbon::createFromDate($year, $month, 1)->startOfMonth();
        $endDate = Carbon::createFromDate($year, $month, 1)->endOfMonth();

        $mostVisitedApps = Aplikasi::withCount([
                'kunjungan as total_kunjungan_bulan_ini' => function ($query) use ($startDate, $endDate) {
                    $query->whereBetween('tanggal_kunjungan', [$startDate, $endDate]);
                }
            ])
            ->with(['fotoAplikasi' => function($query) {
                $query->select('id_aplikasi', 'path_foto')->orderBy('created_at', 'asc')->limit(1);
            }])
            ->orderByDesc('total_kunjungan_bulan_ini')
            ->limit(6)
            ->get()
            ->map(function($app) {
                $thumbnailPath = $app->fotoAplikasi->isNotEmpty() ? $app->fotoAplikasi->first()->path_foto : null;
                return [
                    'id' => $app->id,
                    'nama_aplikasi' => $app->nama_aplikasi,
                    'nama_pemilik' => $app->nama_pemilik,
                    'thumbnail_aplikasi' => $thumbnailPath ? asset('storage/' . $thumbnailPath) : 'https://placehold.co/40x40/cccccc/333333?text=App',
                    'total_kunjungan' => $app->total_kunjungan_bulan_ini,
                ];
            });

        $popularPublishers = DB::table('aplikasi')
            ->select(
                'aplikasi.nama_pemilik',
                DB::raw('MAX(aplikasi.logo) as publisher_logo'),
                DB::raw('COUNT(kunjungan_aplikasis.id) as total_unduhan_apps')
            )
            ->join('kunjungan_aplikasis', 'aplikasi.id', '=', 'kunjungan_aplikasis.aplikasi_id')
            ->whereBetween('kunjungan_aplikasis.tanggal_kunjungan', [$startDate, $endDate])
            ->groupBy('aplikasi.nama_pemilik')
            ->orderByDesc('total_unduhan_apps')
            ->limit(10)
            ->get()
            ->map(function($publisher) {
                return [
                    'nama_pemilik' => $publisher->nama_pemilik,
                    'total_unduhan_apps' => $publisher->total_unduhan_apps,
                    'publisher_logo' => $publisher->publisher_logo
                        ? asset('storage/' . $publisher->publisher_logo)
                        : 'https://placehold.co/32x32/cccccc/333333?text=P',
                ];
            });

        // Grafik Donat: Berita Paling Sering Dilihat (berdasarkan kunjungan_beritas)
        $mostViewedNews = Berita::withCount([
                'kunjungan as total_kunjungan_bulan_ini' => function ($query) use ($startDate, $endDate) {
                    $query->whereBetween('tanggal_kunjungan', [$startDate, $endDate]);
                }
            ])
            ->with('fotoBerita') // relasi untuk ambil thumbnail
            ->orderByDesc('total_kunjungan_bulan_ini')
            ->limit(5)
            ->get();

        $newsChartLabels = $mostViewedNews->pluck('judul_berita')->toArray();
        $newsChartData = $mostViewedNews->pluck('total_kunjungan_bulan_ini')->toArray();

        if (empty($newsChartData) || array_sum($newsChartData) === 0) {
            $newsChartData = array_fill(0, count($mostViewedNews), 1);
        }

        $newsList = $mostViewedNews->map(function ($news) {
            return [
                'id' => $news->id,
                'judul_berita' => $news->judul_berita,
                'thumbnail' => $news->thumbnail_url,
                'total_kunjungan' => $news->total_kunjungan_bulan_ini
            ];
        });

        $latestNews = Berita::whereBetween('tanggal_dibuat', [$startDate, $endDate])
            ->orderBy('tanggal_dibuat', 'desc')
            ->limit(5)
            ->get()
            ->map(function($berita) {
                return [
                    'id' => $berita->id,
                    'judul_berita' => $berita->judul_berita,
                    'tanggal_dibuat' => Carbon::parse($berita->tanggal_dibuat)->locale('id')->isoFormat('D MMMM YYYY')
                ];
            });

        $monthlyRecapLabels = [];
        $monthlyRecapDatasets = [];
        $daysInMonth = $startDate->daysInMonth;

        for ($i = 0; $i < $daysInMonth; $i++) {
            $day = $startDate->copy()->addDays($i);
            $monthlyRecapLabels[] = $day->isoFormat('D');
        }

        $categories = Kategori::where('sub_kategori', 'aplikasi')->get();

        foreach ($categories as $category) {
            $dataForCategory = [];

            for ($i = 0; $i < $daysInMonth; $i++) {
                $day = $startDate->copy()->addDays($i);
                $count = Aplikasi::whereDate('created_at', $day->toDateString())
                    ->where('id_kategori', $category->id)
                    ->count();
                $dataForCategory[] = $count;
            }

            $monthlyRecapDatasets[] = [
                'label' => $category->nama_kategori,
                'data' => $dataForCategory,
                'backgroundColor' => 'rgba(' . rand(0,255) . ',' . rand(0,255) . ',' . rand(0,255) . ', 0.6)',
                'borderColor' => 'rgba(' . rand(0,255) . ',' . rand(0,255) . ',' . rand(0,255) . ', 1)',
                'borderWidth' => 1,
                'borderRadius' => 5,
            ];
        }

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

        return [
            'totalUsers' => User::count(),
            'totalAplikasiDiunggah' => Aplikasi::count(),
            'mostVisitedApps' => $mostVisitedApps,
            'popularPublishers' => $popularPublishers,
            'newsChart' => [
                'labels' => $newsChartLabels,
                'data' => $newsChartData,
            ],
            'mostViewedNewsList' => $newsList,
            'latestNews' => $latestNews,
            'monthlyRecap' => [
                'labels' => $monthlyRecapLabels,
                'datasets' => $monthlyRecapDatasets,
            ]
        ];
    }
}
