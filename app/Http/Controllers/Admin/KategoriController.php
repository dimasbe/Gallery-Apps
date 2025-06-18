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
        $search = $request->query('search');
        $perPage = $request->query('per_page', 5);

        // Inisialisasi query builder
        $query = $this->kategori->query();

        // Terapkan filter
        if ($filter === KategoriTypeEnum::APLIKASI->value) {
            $query->where('sub_kategori', KategoriTypeEnum::APLIKASI->value);
        } elseif ($filter === KategoriTypeEnum::BERITA->value) {
            $query->where('sub_kategori', KategoriTypeEnum::BERITA->value);
        }

        // Terapkan pencarian
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->whereRaw('LOWER(nama_kategori) LIKE ?', ['%' . strtolower($search) . '%'])
                  ->orWhereRaw('LOWER(sub_kategori) LIKE ?', ['%' . strtolower($search) . '%']);
            });
        }

        // Urutkan dan lakukan pagination
        $kategoris = $query->orderBy('tanggal_dibuat', 'desc')->paginate($perPage);

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