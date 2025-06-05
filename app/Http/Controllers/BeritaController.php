<?php

namespace App\Http\Controllers;

use App\Services\BeritaService;
use App\Models\Kategori; // tambahkan ini
use Illuminate\Http\Request;
use App\Models\Berita;

class BeritaController extends Controller
{
    protected $beritaService;

    public function __construct(BeritaService $beritaService)
    {
        $this->beritaService = $beritaService;
    }
    public function index(Request $request)
    {
        $kategoriId = $request->query('kategori');
    
        $beritas = $this->beritaService->getAllPaginated(null, $kategoriId); // null berarti ambil semua
        $kategoris = Kategori::all();
    
        return view('berita.index', compact('beritas', 'kategoris'));
    }
    

    public function show($id)
    {
        $berita = $this->beritaService->findById($id);
        return view('berita.show', compact('berita'));
    }
}
