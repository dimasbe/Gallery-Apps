<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBeritaRequest;
use App\Http\Requests\UpdateBeritaRequest;
use App\Models\Berita;
use App\Services\BeritaService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\QueryException;
use Illuminate\Contracts\View\View;

class AdminBeritaController extends Controller
{
    protected BeritaService $beritaService;

    public function __construct(BeritaService $beritaService)
    {
        $this->beritaService = $beritaService;
    }

    public function index(Request $request)
    {
        $keyword = $request->query('keyword');
        $perPage = $request->query('per_page', 5); // Default 5 berita per halaman

        // Kirim keyword dan perPage ke service untuk paginasi dan filter
        $berita = $this->beritaService->getAllWithKategori($perPage, $keyword);

        return view('admin.berita.index', compact('berita'));
    }

    public function create()
    {
        $kategori = $this->beritaService->getKategoriBerita();
        return view('admin.berita.create', compact('kategori'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreBeritaRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreBeritaRequest $request): JsonResponse
    {
        try {
            // Jika ada kolom kategori_id langsung di data yang divalidasi, tambahkan ke sini
            $validatedData = $request->validated();
            if ($request->has('kategori_id')) {
                $validatedData['kategori_id'] = $request->input('kategori_id'); // Pastikan ini sesuai dengan struktur kategori Anda
            }
            $this->beritaService->createBerita($validatedData, $request->file('thumbnail'));

            return response()->json([
                'success' => true,
                'message' => 'Berita berhasil ditambahkan!',
                'redirect' => route('admin.berita.index')
            ], 200);

        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation Error adding news: ' . $e->getMessage(), ['errors' => $e->errors()]);
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan validasi.',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Error adding news: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return response()->json([
                'success' => false,
                'message' => 'Gagal menambahkan berita: ' . $e->getMessage()
            ], 500);
        }
    }

    public function edit(Berita $berita)
    {
        $kategori = $this->beritaService->getKategoriBerita();
        // Pastikan cara Anda mendapatkan kategori terpilih sesuai dengan relasi di model Berita
        $selectedKategoris = $berita->kategori->pluck('id')->toArray(); // Jika relasi many-to-many
        // Atau jika hanya satu kategori: $selectedKategoris = [$berita->kategori_id];
        return view('admin.berita.edit', compact('berita', 'kategori', 'selectedKategoris'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateBeritaRequest  $request
     * @param  \App\Models\Berita  $berita
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateBeritaRequest $request, Berita $berita): JsonResponse
    {
        try {
            $validatedData = $request->validated();
            if ($request->has('kategori_id')) {
                $validatedData['kategori_id'] = $request->input('kategori_id');
            }
            $this->beritaService->updateBerita($berita, $validatedData, $request->file('thumbnail'));

            return response()->json([
                'success' => true,
                'message' => 'Berita berhasil diperbarui!',
                'redirect' => route('admin.berita.index')
            ], 200);

        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation Error updating news: ' . $e->getMessage(), ['errors' => $e->errors()]);
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan validasi.',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Error updating news: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui berita: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Berita  $berita
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Berita $berita): JsonResponse
    {
        try {
            $this->beritaService->deleteBerita($berita);

            return response()->json([
                'success' => true,
                'message' => 'Berita berhasil dihapus!'
            ], 200);

        } catch (QueryException $e) {
            if ($e->errorInfo[1] == 1451) {
                return response()->json([
                    'success' => false,
                    'message' => 'Berita tidak dapat dihapus karena ada relasi data lain.'
                ], 409);
            }
            Log::error('Error deleting news (QueryException): ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan database saat menghapus.'
            ], 500);
        } catch (\Exception $e) {
            Log::error('Error deleting news: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan sistem, silakan coba lagi.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Menampilkan detail sebuah berita dan mengincrement jumlah kunjungannya.
     *
     * @param  \App\Models\Berita  $berita
     * @return \Illuminate\Contracts\View\View
     */
    public function show(Berita $berita): View
    {
        $berita->increment('jumlah_kunjungan');
        return view('admin.berita.show', compact('berita'));
    }

    /**
     * Metode search ini sekarang sudah diintegrasikan ke index, bisa dihapus jika tidak ada rute terpisah yang memanggilnya.
     * Jika dipertahankan, pastikan juga menggunakan per_page.
     */
    // public function search(Request $request): View
    // {
    //     $keyword = $request->input('keyword', '');
    //     $perPage = $request->query('per_page', 5);
    //     $berita = $this->beritaService->getAllWithKategori($perPage, $keyword);
    //     return view('admin.berita.index', compact('berita'));
    // }
}