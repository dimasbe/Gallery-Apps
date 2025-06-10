<?php

namespace App\Http\Controllers;

use App\Contracts\Interfaces\AplikasiInterface;
use App\Contracts\Interfaces\FotoAplikasiInterface;
use App\Contracts\Interfaces\KategoriInterface;
use App\Http\Requests\StoreAplikasiRequest; // <<< PENTING: Pastikan ini di-import!
use App\Http\Requests\UpdateAplikasiRequest; // Pastikan ini ada jika ada metode update
use App\Models\Aplikasi;
use App\Models\Kategori;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse; // <<< PENTING: Import ini!
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth; // <<< Pastikan ini di-import!
use Illuminate\Support\Facades\Log; // <<< Pastikan ini di-import!

// Pastikan Service Anda sudah ada dan ter-implementasi
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
        $userId = Auth::id();

        $aplikasi = $this->aplikasi->getByUserId($userId);
        $kategori = $this->kategori->get();
        $fotoAplikasi = $this->fotoAplikasi->get();
        return view('tambah_aplikasi.index', compact('aplikasi', 'kategori', 'fotoAplikasi'));
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
                'redirect' => route('tambah_aplikasi.index') // URL untuk redirect di frontend
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
        $aplikasi = $this->aplikasi->get();
        $kategori = $this->kategori->get();
        $fotoAplikasi = $this->fotoAplikasi->get();
        return view('aplikasi.index', compact('aplikasi', 'kategori', 'fotoAplikasi'));
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
            // Asumsi service memiliki metode delete
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
                ], 409); // Conflict
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