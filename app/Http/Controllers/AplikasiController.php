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
use Illuminate\Support\Str; // Import Str, meskipun tidak digunakan secara langsung untuk slug karena sudah di model boot method.

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
        $kategori = $this->kategori->filterBySubKategori('aplikasi');
        $fotoAplikasi = $this->fotoAplikasi->get();

        $aplikasiTerbaru = Aplikasi::where('status_verifikasi', 'diterima')
            ->latest()
            ->paginate(9);
        $columnedResultsTerbaru = $aplikasiTerbaru->chunk(ceil($aplikasiTerbaru->count() / 3));

        $aplikasiPopuler = Aplikasi::where('status_verifikasi', 'diterima')
            ->orderByDesc('jumlah_kunjungan')
            ->paginate(9);
        $columnedResultsPopuler = $aplikasiPopuler->chunk(ceil($aplikasiPopuler->count() / 3));

        $categorizedApplications = $kategori->map(function ($kat) {
            $applications = Aplikasi::where('id_kategori', $kat->id)
                ->where('status_verifikasi', 'diterima')
                ->paginate(9);

            return [
                'category' => $kat,
                'applications' => $applications,
                'columnedResults' => $applications->chunk(ceil($applications->count() / 3)),
            ];
        });

        return view('aplikasi.index', compact(
            'kategori',
            'fotoAplikasi',
            'aplikasiTerbaru',
            'columnedResultsTerbaru',
            'aplikasiPopuler',
            'columnedResultsPopuler',
            'categorizedApplications'
        ));
    }

    public function indexPage(): View
    {
        $userId = Auth::id();
        $aplikasi = $this->aplikasi->getByUserId($userId);
        $kategori = $this->kategori->filterBySubKategori('aplikasi');
        $fotoAplikasi = $this->fotoAplikasi->get();
        return view('tambah_aplikasi.index', compact('aplikasi', 'kategori', 'fotoAplikasi'));
    }

    public function showPopuler(Request $request): View
    {
        $allPopularApplications = Aplikasi::where('status_verifikasi', 'diterima')
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

        return view('aplikasi.populer', [
            'aplikasiPopuler' => $pagedPopularApplications,
            'columnedResultsPopuler' => $columnedPopularResults,
        ]);
    }

    /**
     * Menampilkan daftar aplikasi berdasarkan kategori.
     *
     * @param \App\Models\Kategori $kategori Objek Kategori yang ditemukan berdasarkan slug
     * @return \Illuminate\View\View
     */
    public function showByCategory(Kategori $kategori): View
    {
        // --- DEBUGGING TERAKHIR: UNTUK MEMASTIKAN ROUTE MODEL BINDING BERHASIL ---
        // Setelah Anda melihat output yang benar (ID 1, slug 'game'), HAPUS atau KOMENTARI baris ini.
        // dd('ID Kategori Diterima:', $kategori->id, 'Slug Kategori:', $kategori->slug);
        // -------------------------------------------------------------------------

        $aplikasiByCategory = Aplikasi::where('id_kategori', $kategori->id)
                                    ->where('status_verifikasi', 'diterima')
                                    ->paginate(9);

        $columnedResultsCategory = $this->distributeIntoColumns($aplikasiByCategory);

        return view('aplikasi.kategori_detail', compact('kategori', 'aplikasiByCategory', 'columnedResultsCategory'));
    }


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

    public function search(Request $request): View
        {
            $query = $request->input('q');
            $allSearchResults = collect();

            if ($query) {
                $allSearchResults = Aplikasi::where('status_verifikasi', 'diterima')
                    ->where(function ($qbuilder) use ($query) {
                        $qbuilder->where('nama_aplikasi', 'like', '%' . $query . '%')
                            ->orWhereHas('kategori', function ($kategoriQuery) use ($query) {
                                $kategoriQuery->where('sub_kategori', 'aplikasi')
                                             ->where('nama_kategori', 'like', '%' . $query . '%');
                            });
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

    public function store(StoreAplikasiRequest $request): JsonResponse
    {
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
        $aplikasi->load('kategori', 'fotoAplikasi');
        return view('aplikasi.detail', compact('aplikasi'));
    }

    public function show(Aplikasi $aplikasi): View
    {
        $kategori = $this->kategori->filterBySubKategori('aplikasi');
        $fotoAplikasi = $this->fotoAplikasi->where('id_aplikasi', $aplikasi->id);
        return view('tambah_aplikasi.show', compact('aplikasi', 'kategori', 'fotoAplikasi'));
    }

    public function edit(Aplikasi $aplikasi): View
    {
        if ($aplikasi->id_user !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        $kategori = $this->kategori->filterBySubKategori('aplikasi');
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

    public function destroy(Aplikasi $aplikasi): JsonResponse
    {
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
}