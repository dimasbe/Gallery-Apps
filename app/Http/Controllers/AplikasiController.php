<?php

namespace App\Http\Controllers;

use App\Contracts\Interfaces\AplikasiInterface;
use App\Contracts\Interfaces\FotoAplikasiInterface;
use App\Contracts\Interfaces\KategoriInterface;
use App\Models\Aplikasi;
use App\Models\Kategori;
use App\Models\KunjunganAplikasi;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Pagination\LengthAwarePaginator;

class AplikasiController extends Controller
{
    private AplikasiInterface $aplikasi;
    private KategoriInterface $kategori;
    private FotoAplikasiInterface $fotoAplikasi;

    public function __construct(
        AplikasiInterface $aplikasi,
        FotoAplikasiInterface $fotoAplikasi,
        KategoriInterface $kategori,
    ) {
        $this->aplikasi = $aplikasi;
        $this->kategori = $kategori;
        $this->fotoAplikasi = $fotoAplikasi;
    }

    public function index(): View
    {
        $kategori = $this->kategori->get();
        $fotoAplikasi = $this->fotoAplikasi->get();

        $categorizedApplications = [];
        $perPageForCategory = 9;

        foreach ($kategori as $cat) {
            $allApplicationsInThisCategory = Aplikasi::where('id_kategori', $cat->id)
                ->where('status_verifikasi', 'diterima')
                ->where('arsip', '0')
                ->orderBy('nama_aplikasi', 'asc')
                ->get();

            $currentPageCategory = LengthAwarePaginator::resolveCurrentPage('category_' . $cat->id . '_page');
            $pagedApplicationsInThisCategory = new LengthAwarePaginator(
                $allApplicationsInThisCategory->forPage($currentPageCategory, $perPageForCategory),
                $allApplicationsInThisCategory->count(),
                $perPageForCategory,
                $currentPageCategory,
                ['path' => LengthAwarePaginator::resolveCurrentPath(), 'pageName' => 'category_' . $cat->id . '_page']
            );

            if ($pagedApplicationsInThisCategory->isNotEmpty()) {
                $columnedCategoryResults = $this->distributeIntoColumns($pagedApplicationsInThisCategory);

                $globalStartingIndexCategory = ($pagedApplicationsInThisCategory->currentPage() - 1) * $pagedApplicationsInThisCategory->perPage();

                $categorizedApplications[] = [
                    'category' => $cat,
                    'applications' => $pagedApplicationsInThisCategory,
                    'columnedResults' => $columnedCategoryResults,
                    'globalStartingIndex' => $globalStartingIndexCategory,
                ];
            }
        }

        // --- Aplikasi Populer ---
        $allPopularApplications = Aplikasi::where('status_verifikasi', 'diterima')
            ->where('arsip', '0')
            ->orderBy('jumlah_kunjungan', 'desc')
            ->get();

        $perPagePopular = 18;
        $currentPagePopular = LengthAwarePaginator::resolveCurrentPage('popular_page');
        $aplikasiPopuler = new LengthAwarePaginator(
            $allPopularApplications->forPage($currentPagePopular, $perPagePopular),
            $allPopularApplications->count(),
            $perPagePopular,
            $currentPagePopular,
            ['path' => LengthAwarePaginator::resolveCurrentPath(), 'pageName' => 'popular_page']
        );

        $columnedPopularResults = $this->distributeIntoColumns($aplikasiPopuler);
        $globalStartingIndexPopuler = ($aplikasiPopuler->currentPage() - 1) * $aplikasiPopuler->perPage();

        // --- Semua Aplikasi ---
        $allAplikasis = Aplikasi::where('status_verifikasi', 'diterima')
            ->where('arsip', '0')
            ->orderBy('nama_aplikasi', 'asc')
            ->get();

        $perPageAll = 18;
        $currentPageAll = LengthAwarePaginator::resolveCurrentPage('all_page');
        $paginatedAplikasis = new LengthAwarePaginator(
            $allAplikasis->forPage($currentPageAll, $perPageAll),
            $allAplikasis->count(),
            $perPageAll,
            $currentPageAll,
            ['path' => LengthAwarePaginator::resolveCurrentPath(), 'pageName' => 'all_page']
        );

        $globalStartingIndexAll = ($paginatedAplikasis->currentPage() - 1) * $paginatedAplikasis->perPage();

        return view('aplikasi.index', compact(
            'aplikasiPopuler',
            'columnedPopularResults',
            'categorizedApplications',
            'kategori',
            'fotoAplikasi',
            'globalStartingIndexPopuler',
            'paginatedAplikasis',
            'globalStartingIndexAll'
        ));
    }

    public function showPopuler(Request $request): View
    {
        $allPopularApplications = Aplikasi::where('status_verifikasi', 'diterima')
            ->where('arsip', '0')
            ->orderBy('jumlah_kunjungan', 'desc')
            ->get();

        $perPagePopular = 18;
        $currentPagePopular = LengthAwarePaginator::resolveCurrentPage('popular_page');
        $pagedPopularApplications = new LengthAwarePaginator(
            $allPopularApplications->forPage($currentPagePopular, $perPagePopular),
            $allPopularApplications->count(),
            $perPagePopular,
            $currentPagePopular,
            ['path' => LengthAwarePaginator::resolveCurrentPath(), 'pageName' => 'popular_page']
        );

        $columnedPopularResults = $this->distributeIntoColumns($pagedPopularApplications);
        $globalStartingIndexPopuler = ($pagedPopularApplications->currentPage() - 1) * $pagedPopularApplications->perPage();

        return view('aplikasi.populer', [
            'aplikasiPopuler' => $pagedPopularApplications,
            'columnedPopularResults' => $columnedPopularResults,
            'globalStartingIndexPopuler' => $globalStartingIndexPopuler,
        ]);
    }

    public function distributeIntoColumns(LengthAwarePaginator $paginatedItems): array
    {
        $columnedResults = [[], [], []];
        $itemsOnCurrentPage = $paginatedItems->count();

        if ($itemsOnCurrentPage > 0) {
            $actualItemsPerVisualColumn = ceil($itemsOnCurrentPage / 3);
            $itemsArray = $paginatedItems->items();

            for ($i = 0; $i < $itemsOnCurrentPage; ++$i) {
                $aplikasi = $itemsArray[$i];
                $colIndex = (int)floor($i / $actualItemsPerVisualColumn);
                $colIndex = min($colIndex, 2);
                $columnedResults[$colIndex][] = $aplikasi;
            }
        }

        return $columnedResults;
    }

    public function search(Request $request): View
    {
        $query = $request->input('q');
        $allSearchResults = collect();

        if ($query) {
            $allSearchResults = Aplikasi::where('nama_aplikasi', 'like', '%' . $query . '%')
                ->orWhereHas('kategori', function ($q) use ($query) {
                    $q->where('nama_kategori', 'like', '%' . $query . '%');
                })
                ->get();
        }

        $perPage = 18;
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $pagedResults = new LengthAwarePaginator(
            $allSearchResults->forPage($currentPage, $perPage),
            $allSearchResults->count(),
            $perPage,
            $currentPage,
            ['path' => LengthAwarePaginator::resolveCurrentPath()]
        );

        $columnedResults = $this->distributeIntoColumns($pagedResults);
        $globalStartingIndexSearch = ($pagedResults->currentPage() - 1) * $pagedResults->perPage();

        return view('search_results', [
            'query' => $query,
            'results' => $pagedResults,
            'columnedResults' => $columnedResults,
            'globalStartingIndex' => $globalStartingIndexSearch,
        ]);
    }

    public function showAplikasi(Aplikasi $aplikasi): View
    {
        // Tambah jumlah kunjungan ke kolom aplikasi
        $aplikasi->increment('jumlah_kunjungan');

        // Simpan data kunjungan ke tabel kunjungan_aplikasis
        KunjunganAplikasi::create([
            'aplikasi_id' => $aplikasi->id,
            'ip_address' => request()->ip(),
            'user_agent' => request()->header('User-Agent'),
            'tanggal_kunjungan' => now(),
        ]);

        $kategori = $this->kategori->get();
        $fotoAplikasi = $this->fotoAplikasi->where('id_aplikasi', $aplikasi->id);

        return view('aplikasi.detail', compact('aplikasi', 'kategori', 'fotoAplikasi'));
    }

    public function showByCategory(string $nama_kategori, Request $request): View
    {
        $category = Kategori::where('nama_kategori', $nama_kategori)
            ->where('sub_kategori', 'aplikasi')
            ->firstOrFail();

        $allCategoryApps = Aplikasi::where('id_kategori', $category->id)
            ->orderBy('nama_aplikasi', 'asc')
            ->get();

        $perPage = 18;
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $pagedCategoryApps = new LengthAwarePaginator(
            $allCategoryApps->forPage($currentPage, $perPage),
            $allCategoryApps->count(),
            $perPage,
            $currentPage,
            ['path' => LengthAwarePaginator::resolveCurrentPath()]
        );

        $columnedResults = $this->distributeIntoColumns($pagedCategoryApps);
        $globalStartingIndexCategory = ($pagedCategoryApps->currentPage() - 1) * $pagedCategoryApps->perPage();

        return view('aplikasi.kategori_detail', [
            'category' => $category,
            'applications' => $pagedCategoryApps,
            'columnedResults' => $columnedResults,
            'globalStartingIndex' => $globalStartingIndexCategory,
        ]);
    }
}
