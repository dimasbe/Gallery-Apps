<?php

namespace App\Http\Controllers;

use App\Contracts\Interfaces\AplikasiInterface;
use App\Contracts\Interfaces\FotoAplikasiInterface;
use App\Contracts\Interfaces\KategoriInterface;
use App\Http\Requests\StoreAplikasiRequest;
use App\Http\Requests\UpdateAplikasiRequest;
use App\Models\Aplikasi;
use App\Models\Kategori;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Pagination\LengthAwarePaginator;

use App\Services\AplikasiService;
use App\Services\FotoAplikasiService;
use App\Services\LogoAplikasiService;


class AplikasiController extends Controller
{
    private AplikasiInterface $aplikasi;
    private KategoriInterface $kategori;
    private FotoAplikasiInterface $fotoAplikasi;
    private FotoAplikasiService $fotoAplikasiService;
    private LogoAplikasiService $logoAplikasiService;
    private AplikasiService $aplikasiService;

    public function __construct(
        AplikasiInterface $aplikasi,
        FotoAplikasiInterface $fotoAplikasi,
        KategoriInterface $kategori,
        FotoAplikasiService $fotoAplikasiService,
        LogoAplikasiService $logoAplikasiService,
        AplikasiService $aplikasiService
    ) {
        $this->aplikasi = $aplikasi;
        $this->kategori = $kategori;
        $this->fotoAplikasi = $fotoAplikasi;
        $this->fotoAplikasiService = $fotoAplikasiService;
        $this->logoAplikasiService = $logoAplikasiService;
        $this->aplikasiService = $aplikasiService;
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

        // --- Semua Aplikasi (flat mendatar) ---
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


    public function indexPage(): View
    {
        $userId = Auth::id();
        $aplikasi = $this->aplikasi->getByUserId($userId);
        $kategori = $this->kategori->get();
        $fotoAplikasi = $this->fotoAplikasi->get();
        return view('tambah_aplikasi.index', compact('aplikasi', 'kategori', 'fotoAplikasi'));
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

        // Menghitung indeks awal global untuk paginasi populer di showPopuler
        $globalStartingIndexPopuler = ($pagedPopularApplications->currentPage() - 1) * $pagedPopularApplications->perPage();

        return view('aplikasi.populer', [
            'aplikasiPopuler' => $pagedPopularApplications,
            'columnedPopularResults' => $columnedPopularResults,
            'globalStartingIndexPopuler' => $globalStartingIndexPopuler, // <--- Pastikan ini ada
        ]);
    }

    // Mengubah visibilitas menjadi public agar bisa diakses jika diperlukan,
    // meskipun disarankan untuk memanggilnya di controller
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

        // Menghitung indeks awal global untuk hasil pencarian
        $globalStartingIndexSearch = ($pagedResults->currentPage() - 1) * $pagedResults->perPage();


        return view('search_results', [
            'query' => $query,
            'results' => $pagedResults,
            'columnedResults' => $columnedResults,
            'globalStartingIndex' => $globalStartingIndexSearch, // <--- Tambahkan ini
        ]);
    }


    public function create(): View
    {
        $kategori = $this->kategori->filterBySubKategori('aplikasi');
        $fotoAplikasi = $this->fotoAplikasi->get();
        return view('tambah_aplikasi.create', compact('kategori', 'fotoAplikasi'));
    }

    public function store(StoreAplikasiRequest $request): JsonResponse {
        try {
            $validated = $request->validated();
            $validated['id_user'] = Auth::id();

            if ($request->hasFile('logo')) {
                $validated['logo'] = $this->logoAplikasiService->store($request->file('logo'));
            } else {
                $validated['logo'] = null;
            }

            $files = $request->hasFile('path_foto') ? $request->file('path_foto') : null;

            $this->aplikasiService->createWithFotos($validated, $files);

            return response()->json([
                'success' => true,
                'message' => 'Aplikasi Berhasil Ditambahkan!',
                'redirect' => route('tambah_aplikasi.index')
            ], 200);

        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation Error adding application: ' . $e->getMessage(), ['errors' => $e->errors()]);
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal. Silakan periksa kembali form Anda.',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Error adding application: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan sistem, silakan coba lagi.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function showAplikasi(Aplikasi $aplikasi): View
    {
        $aplikasi->increment('jumlah_kunjungan');

        $kategori = $this->kategori->get();
        $fotoAplikasi = $this->fotoAplikasi->where('id_aplikasi', $aplikasi->id);
        return view('aplikasi.detail', compact('aplikasi', 'kategori', 'fotoAplikasi'));
    }

    public function show(Aplikasi $aplikasi): View
    {
        $kategori = $this->kategori->get();
        $fotoAplikasi = $this->fotoAplikasi->where('id_aplikasi', $aplikasi->id);
        return view('tambah_aplikasi.show', compact('aplikasi', 'kategori', 'fotoAplikasi'));
    }

    public function edit(Aplikasi $aplikasi): View
    {
        if ($aplikasi->id_user !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        $kategori = $this->kategori->get();
        $aplikasi->load('fotoAplikasi');
        return view('tambah_aplikasi.edit', compact('aplikasi', 'kategori'));
    }

    public function update(UpdateAplikasiRequest $request, Aplikasi $aplikasi): JsonResponse
    {
        try {
            $validated = $request->validated();

            $logoFile = $request->file('path_logo');
            $fotoFiles = $request->file('path_foto');

            $fotoFiles = is_array($fotoFiles) && count($fotoFiles) > 0 ? $fotoFiles : null;

            if ($logoFile) {
                $validated['path_logo'] = $logoFile;
            }

            $updatedAplikasi = $this->aplikasiService->updateWithFotos(
                $aplikasi->id,
                $validated,
                $fotoFiles
            );

            return response()->json([
                'success' => true,
                'message' => 'Aplikasi Berhasil Diperbarui!',
                'data' => $updatedAplikasi,
                'redirect' => route('tambah_aplikasi.index')
            ], 200);

        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation Error updating application: ' . $e->getMessage(), ['errors' => $e->errors()]);
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal. Periksa kembali form Anda.',
                'errors' => $e->errors()
            ], 422);

        } catch (\Exception $e) {
            Log::error('Error updating application: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan sistem, silakan coba lagi.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy(Aplikasi $aplikasi): JsonResponse {
        try {
            $this->aplikasiService->deleteAplikasiAndFiles($aplikasi->id);

            return response()->json([
                'success' => true,
                'message' => 'Aplikasi Berhasil Dihapus!',
                'redirect' => route('tambah_aplikasi.index')
            ], 200);

        } catch (QueryException $e) {
            if ($e->errorInfo[1] == 1451) {
                return response()->json([
                    'success' => false,
                    'message' => 'Aplikasi tidak dapat dihapus karena ada relasi data lain.'
                ], 409);
            }
            Log::error('Error deleting application (QueryException): ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan database saat menghapus.'
                ], 500);
        } catch (\Exception $e) {
            Log::error('Error deleting application: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan sistem, silakan coba lagi.'
            ], 500);
        }
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

        // Menghitung indeks awal global untuk kategori
        $globalStartingIndexCategory = ($pagedCategoryApps->currentPage() - 1) * $pagedCategoryApps->perPage();


        return view('aplikasi.kategori_detail', [
            'category' => $category,
            'applications' => $pagedCategoryApps,
            'columnedResults' => $columnedResults,
            'globalStartingIndex' => $globalStartingIndexCategory, // <--- Tambahkan ini
        ]);
    }
}