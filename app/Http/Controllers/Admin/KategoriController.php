<?php

namespace App\Http\Controllers\Admin;

use App\Contracts\Interfaces\KategoriInterface;
use App\Enums\KategoriTypeEnum; // Import the enum
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreKategoriRequest; // Import new request
use App\Http\Requests\UpdateKategoriRequest; // Import new request
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use RealRashid\SweetAlert\Facades\Alert; // Assuming SweetAlert is used

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
        $kategoris = collect(); // Initialize an empty collection

        // Filter categories based on the selected type
        if ($filter === KategoriTypeEnum::APLIKASI->value) {
            $kategoris = $this->kategori->filterBySubKategori(KategoriTypeEnum::APLIKASI->value);
        } elseif ($filter === KategoriTypeEnum::BERITA->value) {
            $kategoris = $this->kategori->filterBySubKategori(KategoriTypeEnum::BERITA->value);
        } else {
            $kategoris = $this->kategori->get();
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
