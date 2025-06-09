<?php // Pastikan ini baris pertama, tanpa spasi/komentar di atasnya

namespace App\Http\Controllers;

use App\Contracts\Interfaces\AplikasiInterface;
use App\Contracts\Interfaces\FotoAplikasiInterface;
use App\Contracts\Interfaces\KategoriInterface;
use App\Http\Requests\StoreAplikasiRequest;
use App\Http\Requests\UpdateAplikasiRequest;
use App\Models\Aplikasi;
use App\Models\Kategori; // Pastikan Kategori di-import
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Pagination\LengthAwarePaginator;

use App\Services\AplikasiService; // Pastikan ini di-import
use App\Services\FotoAplikasiService; // Pastikan ini di-import
use App\Services\LogoAplikasiService; // Pastikan ini di-import


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
        $this->logoAplikasiService = $logoAplikasiService;
        $this->aplikasiService = $aplikasiService;
    }

    public function index(Request $request): View
    {
        // --- 1. Query untuk Paling Populer (berdasarkan jumlah_kunjungan) ---
        $allPopularApplications = Aplikasi::orderBy('jumlah_kunjungan', 'desc')->get(); // Mengurutkan berdasarkan kunjungan

        $perPagePopular = 18; // 6 baris * 3 kolom
        $currentPagePopular = LengthAwarePaginator::resolveCurrentPage('popular_page'); // Gunakan nama unik untuk paginator
        $pagedPopularApplications = new LengthAwarePaginator(
            $allPopularApplications->forPage($currentPagePopular, $perPagePopular),
            $allPopularApplications->count(),
            $perPagePopular,
            $currentPagePopular,
            ['path' => LengthAwarePaginator::resolveCurrentPath(), 'pageName' => 'popular_page'] // Tambahkan pageName
        );

        $columnedPopularResults = $this->distributeIntoColumns($pagedPopularApplications);


        // --- 2. Query untuk Aplikasi per Kategori ---
        $allCategories = Kategori::where('sub_kategori', 'aplikasi')->get(); // Ambil semua kategori aplikasi

        $categorizedApplications = [];
        $perPageCategory = 18; // Atur jumlah item per halaman untuk setiap kategori

        foreach ($allCategories as $category) {
            $categoryApps = Aplikasi::where('id_kategori', $category->id)
                                    ->orderBy('nama_aplikasi', 'asc') // Urutkan sesuai kategori
                                    ->get();

            $currentPageCategory = LengthAwarePaginator::resolveCurrentPage('category_' . $category->id . '_page');
            $pagedCategoryApps = new LengthAwarePaginator(
                $categoryApps->forPage($currentPageCategory, $perPageCategory),
                $categoryApps->count(),
                $perPageCategory,
                $currentPageCategory,
                ['path' => LengthAwarePaginator::resolveCurrentPath(), 'pageName' => 'category_' . $category->id . '_page']
            );

            $categorizedApplications[] = [
                'category' => $category,
                'applications' => $pagedCategoryApps,
                'columnedResults' => $this->distributeIntoColumns($pagedCategoryApps)
            ];
        }


        return view('aplikasi.index', [
            'aplikasiPopuler' => $pagedPopularApplications,
            'columnedResultsPopuler' => $columnedPopularResults,
            'categorizedApplications' => $categorizedApplications, // Kirim data per kategori
        ]);
    }

    /**
     * Menampilkan daftar aplikasi paling populer.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function showPopuler(Request $request): View
    {
        // Mengambil semua aplikasi populer berdasarkan jumlah_kunjungan
        $allPopularApplications = Aplikasi::orderBy('jumlah_kunjungan', 'desc')->get();

        // Mengatur paginasi untuk aplikasi populer
        $perPagePopular = 18; // Sesuaikan dengan jumlah item per halaman yang Anda inginkan
        $currentPagePopular = LengthAwarePaginator::resolveCurrentPage('popular_page');
        $pagedPopularApplications = new LengthAwarePaginator(
            $allPopularApplications->forPage($currentPagePopular, $perPagePopular),
            $allPopularApplications->count(),
            $perPagePopular,
            $currentPagePopular,
            ['path' => LengthAwarePaginator::resolveCurrentPath(), 'pageName' => 'popular_page']
        );

        // Mendistribusikan aplikasi ke dalam kolom visual untuk tampilan
        $columnedPopularResults = $this->distributeIntoColumns($pagedPopularApplications);

        // Mengembalikan view 'aplikasi.populer' dengan data aplikasi populer
        return view('aplikasi.populer', [ // PERUBAHAN: Mengarahkan ke 'aplikasi.populer'
            'aplikasiPopuler' => $pagedPopularApplications,
            'columnedResultsPopuler' => $columnedPopularResults,
        ]);
    }

    /**
     * Helper function to distribute items into 3 columns for display.
     *
     * @param LengthAwarePaginator $paginatedItems
     * @return array
     */
    private function distributeIntoColumns(LengthAwarePaginator $paginatedItems): array
    {
        $columnedResults = [[], [], []];
        $itemsOnCurrentPage = $paginatedItems->count();

        if ($itemsOnCurrentPage > 0) {
            $actualItemsPerVisualColumn = ceil($itemsOnCurrentPage / 3);
            $itemsArray = $paginatedItems->items();

            for ($i = 0; $i < $itemsOnCurrentPage; $i++) {
                $aplikasi = $itemsArray[$i];
                $colIndex = floor($i / $actualItemsPerVisualColumn);
                $colIndex = min($colIndex, 2);
                $columnedResults[$colIndex][] = $aplikasi;
            }
        }
        return $columnedResults;
    }


    /**
     * Handle the search request for applications by name or category.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
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


        return view('search_results', [
            'query' => $query,
            'results' => $pagedResults,
            'columnedResults' => $columnedResults,
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

    public function detail(Aplikasi $aplikasi): View
    {
        // <<< INKREMEN JUMLAH KUNJUNGAN DI SINI <<<
        $aplikasi->increment('jumlah_kunjungan');
        // >>> AKHIR INKREMEN <<<

        $aplikasi->load('kategori', 'fotoAplikasi');
        return view('aplikasi.detail', compact('aplikasi'));
    }


    public function edit(Aplikasi $aplikasi): View
    {
        if ($aplikasi->id_user !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        $kategori = Kategori::where('sub_kategori', 'aplikasi')->get();
        $aplikasi->load('fotoAplikasi');
        return view('tambah_aplikasi.edit', compact('aplikasi', 'kategori'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateAplikasiRequest  $request
     * @param  \App\Models\Aplikasi  $aplikasi
     * @return \Illuminate\Http\JsonResponse // <<< PASTIKAN TIPE KEMBALIAN INI
     */
    public function update(UpdateAplikasiRequest $request, Aplikasi $aplikasi): JsonResponse
    {
        try {
            $validated = $request->validated();

            // Ambil file logo dan foto dari request, bisa null jika tidak dikirim
            $logoFile = $request->file('path_logo');
            $fotoFiles = $request->file('path_foto');

            // Buat array kosong kalau tidak ada file dikirim
            $fotoFiles = is_array($fotoFiles) && count($fotoFiles) > 0 ? $fotoFiles : null;

            // Tambahkan logo ke validated jika ada
            if ($logoFile) {
                $validated['path_logo'] = $logoFile;
            }

            $this->aplikasiService->updateWithFotos($aplikasi->id, $validated, $fotoFiles);

            // Panggil service update dengan parameter yang sesuai
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
            \Log::error('Validation Error updating application: ' . $e->getMessage(), ['errors' => $e->errors()]);
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal. Periksa kembali form Anda.',
                'errors' => $e->errors()
            ], 422);

        } catch (\Exception $e) {
            \Log::error('Error updating application: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
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

    /**
     * Display all applications for a specific category.
     *
     * @param string $nama_kategori
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function showByCategory(string $nama_kategori, Request $request): View
    {
        // Temukan kategori berdasarkan nama
        $category = Kategori::where('nama_kategori', $nama_kategori)
                            ->where('sub_kategori', 'aplikasi') // Opsional: pastikan hanya kategori aplikasi
                            ->firstOrFail(); // Akan 404 jika tidak ditemukan

        // Ambil semua aplikasi dalam kategori tersebut
        $allCategoryApps = Aplikasi::where('id_kategori', $category->id)
                                   ->orderBy('nama_aplikasi', 'asc')
                                   ->get();

        // Paginasi hasil
        $perPage = 18; // Sesuaikan dengan jumlah item per halaman yang Anda inginkan
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $pagedCategoryApps = new LengthAwarePaginator(
            $allCategoryApps->forPage($currentPage, $perPage),
            $allCategoryApps->count(),
            $perPage,
            $currentPage,
            ['path' => LengthAwarePaginator::resolveCurrentPath()]
        );

        // Distribusikan ke kolom jika diperlukan untuk tampilan
        $columnedResults = $this->distributeIntoColumns($pagedCategoryApps);

        return view('aplikasi.kategori_detail', [ // Buat view baru untuk ini, misal 'kategori_detail.blade.php'
            'category' => $category,
            'applications' => $pagedCategoryApps,
            'columnedResults' => $columnedResults,
        ]);
    }
}
