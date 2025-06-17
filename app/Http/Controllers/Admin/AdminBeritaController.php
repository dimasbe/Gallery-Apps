<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBeritaRequest;
use App\Http\Requests\UpdateBeritaRequest; // Pastikan ini diimpor
use App\Models\Berita;
use App\Services\BeritaService; // Pastikan ini diimpor
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\QueryException;
use Illuminate\Contracts\View\View; // Mengimpor interface View

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

        // Kirim keyword ke service agar berita bisa difilter
        $berita = $this->beritaService->getAllWithKategori($keyword);

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
            $this->beritaService->createBerita($request->validated(), $request->file('thumbnail'));

            return response()->json([
                'success' => true,
                'message' => 'Berita berhasil ditambahkan!',
                'redirect' => route('admin.berita.index') // Redirect ke halaman index setelah berhasil
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
        $selectedKategoris = $berita->kategori->pluck('id')->toArray(); // Jika ada relasi many-to-many atau kategori tunggal
        // Jika kategori_id adalah kolom langsung di tabel berita, Anda bisa gunakan $berita->kategori_id
        // Atau jika hanya satu kategori, $selectedKategoris mungkin tidak diperlukan
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
            $this->beritaService->updateBerita($berita, $request->validated(), $request->file('thumbnail'));

            return response()->json([
                'success' => true,
                'message' => 'Berita berhasil diperbarui!',
                'redirect' => route('admin.berita.index') // Redirect ke halaman index setelah berhasil
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
                ], 409); // Conflict
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
     * Logika increment ditambahkan di sini karena permintaan pengguna untuk digabungkan.
     *
     * @param  \App\Models\Berita  $berita
     * @return \Illuminate\Contracts\View\View
     */
    public function show(Berita $berita): View
    {
        // --- Logika untuk mengincrement jumlah_kunjungan ---
        // Jika method 'show' ini juga digunakan untuk tampilan publik, maka increment ini akan berfungsi.
        // Jika ini hanya untuk tampilan admin internal, pertimbangkan untuk menghapus baris ini
        // atau memiliki logika terpisah untuk increment hanya di rute publik.
        $berita->increment('jumlah_kunjungan');

        return view('admin.berita.show', compact('berita'));
    }

    /**
     * Mencari berita berdasarkan keyword menggunakan BeritaService.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function search(Request $request): View // Menambahkan type hinting View
    {
        $keyword = $request->input('keyword', '');
        // PERBAIKAN DI SINI: Menggunakan beritaService yang sudah diinjeksikan
        $berita = $this->beritaService->getAllWithKategori($keyword); 
        
        // Asumsi view 'admin.berita.index' atau view lain yang sesuai untuk menampilkan hasil pencarian
        return view('admin.berita.index', compact('berita')); 
    }
}
