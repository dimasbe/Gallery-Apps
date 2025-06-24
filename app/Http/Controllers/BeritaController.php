<?php

namespace App\Http\Controllers; 

use App\Services\BeritaService;
use App\Models\Kategori;
use Illuminate\Http\Request;


class BeritaController extends Controller
{
    protected BeritaService $beritaService;

    public function __construct(BeritaService $beritaService)
    {
        $this->beritaService = $beritaService;
    }
    public function index(Request $request)
    {
        $kategoriId = $request->query('kategori');
        $search = $request->query('search');
        $perPage = $request->query('perPage', 5);
    
        // Panggil method yang benar untuk mendukung filter kategori dan pencarian
        $beritas = $this->beritaService->getAllPaginated($perPage, $kategoriId, $search);
    
        $kategoris = Kategori::where('sub_kategori', 'berita')->get();
    
        return view('berita.index', compact('beritas', 'kategoris'));
    }
    
    public function show(int $id)
    {
        // Mengambil berita dari service
        $berita = $this->beritaService->findById($id);

        // Increment jumlah kunjungan
        $berita->increment('jumlah_kunjungan');

        // Mengambil berita terkait berdasarkan kategori_id
        $beritaTerkait = $this->beritaService->getBeritaTerkait($berita->kategori_id, $berita->id);

        // Mengambil semua kategori dengan sub_kategori 'berita'
        $kategoris = Kategori::where('sub_kategori', 'berita')->get();

        // Menampilkan view berita/show dengan data yang dibutuhkan
        return view('berita.show', compact('berita', 'beritaTerkait', 'kategoris'));
    }
}    

