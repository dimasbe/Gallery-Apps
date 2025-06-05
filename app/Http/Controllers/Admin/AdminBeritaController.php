<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBeritaRequest;
use App\Http\Requests\UpdateBeritaRequest;
use App\Models\Berita;
use App\Services\BeritaService;
use Illuminate\Http\Request;

class AdminBeritaController extends Controller
{
    protected BeritaService $beritaService;

    public function __construct(BeritaService $beritaService)
    {
        $this->beritaService = $beritaService;
    }

    public function index()
    {
        $berita = $this->beritaService->getAllWithKategori();
        return view('admin.berita.index', compact('berita'));
    }

    public function create()
    {
        $kategori = $this->beritaService->getKategoriBerita();
        return view('admin.berita.create', compact('kategori'));
    }

    public function store(StoreBeritaRequest $request)
    {
        $this->beritaService->createBerita($request->validated(), $request->file('thumbnail'));
        return redirect()->route('admin.berita.index')->with('success', 'Berita berhasil ditambahkan.');
    }

    public function edit(Berita $berita)
    {
        $kategori = $this->beritaService->getKategoriBerita();
        $selectedKategoris = $berita->kategoris->pluck('id')->toArray(); // Ambil ID kategori yang terkait
    
        return view('admin.berita.edit', compact('berita', 'kategori', 'selectedKategoris'));
    }
    

    public function update(UpdateBeritaRequest $request, Berita $berita)
    {
        $this->beritaService->updateBerita($berita, $request->validated(), $request->file('thumbnail'));
        return redirect()->route('admin.berita.index')->with('success', 'Berita berhasil diperbarui.');
    }

    public function destroy(Berita $berita)
    {
        $this->beritaService->deleteBerita($berita);
        return redirect()->route('admin.berita.index')->with('success', 'Berita berhasil dihapus.');
    }

    public function search(Request $request)
    {
        $keyword = $request->input('keyword');
        $berita = $this->beritaService->searchBerita($keyword);
        return view('admin.berita.index', compact('berita', 'keyword'));
    }

    public function show(Berita $berita)
    {
        // Bisa passing data berita ke view detail
        return view('admin.berita.show', compact('berita'));
    }
    

}
