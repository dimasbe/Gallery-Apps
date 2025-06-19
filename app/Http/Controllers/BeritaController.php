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
}    
