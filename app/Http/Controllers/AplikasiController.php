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
use Illuminate\Support\Facades\Log; // Pastikan ini sudah ada dan benar
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

    public function index(): View
    {
        // Ambil semua kategori
        $kategori = $this->kategori->get(); // Ini akan mengembalikan semua kategori
        $fotoAplikasi = $this->fotoAplikasi->get(); // Ambil semua foto aplikasi

        // Inisialisasi array untuk aplikasi yang dikelompokkan berdasarkan kategori
        $categorizedApplications = [];
        $perPageForCategory = 18; // Tentukan jumlah item per halaman untuk setiap kategori

        // Loop melalui setiap kategori dan ambil aplikasi terkait
        foreach ($kategori as $cat) {
            // Ambil semua aplikasi di kategori ini
            $allApplicationsInThisCategory = Aplikasi::where('id_kategori', $cat->id)
                                                    ->with('fotoAplikasi') // Load fotoAplikasi jika perlu ditampilkan
                                                    ->get();

            // Lakukan paginasi untuk aplikasi di kategori saat ini
            $currentPageCategory = LengthAwarePaginator::resolveCurrentPage('category_' . $cat->id . '_page');
            $pagedApplicationsInThisCategory = new LengthAwarePaginator(
                $allApplicationsInThisCategory->forPage($currentPageCategory, $perPageForCategory),
                $allApplicationsInThisCategory->count(),
                $perPageForCategory,
                $currentPageCategory,
                ['path' => LengthAwarePaginator::resolveCurrentPath(), 'pageName' => 'category_' . $cat->id . '_page']
            );

            // Tambahkan ke array categorizedApplications jika ada aplikasi di kategori ini
            if ($pagedApplicationsInThisCategory->isNotEmpty()) {
                // Distribusikan aplikasi yang sudah di-paginasi ke dalam kolom
                $columnedCategoryResults = $this->distributeIntoColumns($pagedApplicationsInThisCategory);
                
                $categorizedApplications[] = [
                    'category' => $cat, // Teruskan objek kategori lengkap jika diperlukan
                    'applications' => $pagedApplicationsInThisCategory, // Teruskan collection yang sudah di-paginasi
                    'columnedResults' => $columnedCategoryResults, // Tambahkan hasil kolom di sini
                ];
            }
        }

        // Tambahan: Ambil aplikasi populer berdasarkan jumlah kunjungan
        $aplikasiPopuler = Aplikasi::orderBy('jumlah_kunjungan', 'desc')
                                     ->limit(6) // Sesuaikan jumlah yang ingin ditampilkan
                                     ->get();

        // Teruskan semua variabel yang dibutuhkan ke view
        return view('aplikasi.index', compact('aplikasiPopuler', 'categorizedApplications', 'kategori', 'fotoAplikasi'));
    }


    public function indexPage(): View
    {        
        $userId = Auth::id();

        $aplikasi = $this->aplikasi->getByUserId($userId);
        $kategori = $this->kategori->get();
        $fotoAplikasi = $this->fotoAplikasi->get();
        return view('tambah_aplikasi.index', compact('aplikasi', 'kategori', 'fotoAplikasi'));
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

            for ($i = 0; $i < $itemsOnCurrentPage; ++$i) {
                $aplikasi = $itemsArray[$i];
                $colIndex = (int)floor($i / $actualItemsPerVisualColumn);
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

    public function showAplikasi(Aplikasi $aplikasi): View
    {
        // <<< INKREMEN JUMLAH KUNJUNGAN DI SINI <<<
        $aplikasi->increment('jumlah_kunjungan');
        // >>> AKHIR INKREMEN <<<

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
        $kategori = Kategori::where('sub_kategori', 'aplikasi')->get(); 
        $aplikasi->load('fotoAplikasi');
        return view('tambah_aplikasi.edit', compact('aplikasi', 'kategori')); 
    }

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
            Log::error('Validation Error updating application: ' . $e->getMessage(), ['errors' => $e->errors()]); // Perbaikan di sini
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal. Periksa kembali form Anda.',
                'errors' => $e->errors()
            ], 422);

        } catch (\Exception $e) {
            Log::error('Error updating application: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]); // Perbaikan di sini
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
