<?php

namespace App\Http\Controllers\Admin;

use App\Contracts\Interfaces\KategoriInterface;
use App\Enums\KategoriTypeEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreKategoriRequest;
use App\Http\Requests\UpdateKategoriRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use RealRashid\SweetAlert\Facades\Alert;

class KategoriController extends Controller
{
    private KategoriInterface $kategori;

    public function __construct(KategoriInterface $kategori)
    {
        $this->kategori = $kategori;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $filter = $request->query('filter', 'semua');
        $search = $request->query('search'); // Ambil parameter pencarian

        $kategoris = collect(); // Inisialisasi koleksi kosong

        // Dapatkan semua kategori atau yang difilter terlebih dahulu
        if ($filter === KategoriTypeEnum::APLIKASI->value) {
            $kategoris = $this->kategori->filterBySubKategori(KategoriTypeEnum::APLIKASI->value);
        } elseif ($filter === KategoriTypeEnum::BERITA->value) {
            $kategoris = $this->kategori->filterBySubKategori(KategoriTypeEnum::BERITA->value);
        } else {
            $kategoris = $this->kategori->get(); // Asumsi method get() mengambil semua data
        }

        // Terapkan pencarian jika ada
        if ($search) {
            $kategoris = $kategoris->filter(function ($kategori) use ($search) {
                // Konversi nama_kategori dan sub_kategori ke lowercase untuk pencarian case-insensitive
                $searchLower = strtolower($search);
                $namaKategoriLower = strtolower($kategori->nama_kategori);
                $subKategoriLower = strtolower($kategori->sub_kategori);

                // Cek apakah search term ada di nama_kategori atau sub_kategori
                return str_contains($namaKategoriLower, $searchLower) ||
                       str_contains($subKategoriLower, $searchLower);
            });
        }

        return view('admin.kategori.index', compact('kategoris', 'filter'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreKategoriRequest $request): JsonResponse
    {
        $this->kategori->store($request->validated());

        // Return a JSON response indicating success
        return response()->json(['message' => 'Kategori berhasil ditambahkan!'], 201);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): JsonResponse
    {
        $kategori = $this->kategori->show($id);
        return response()->json($kategori);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        $kategori = $this->kategori->show($id);
        return response()->json($kategori);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateKategoriRequest $request, string $id): JsonResponse
    {
        $this->kategori->update($id, $request->validated());

        return response()->json(['message' => 'Kategori berhasil diupdate!']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        $this->kategori->delete($id);
        return response()->json(['message' => 'Kategori berhasil dihapus!']);
    }
}