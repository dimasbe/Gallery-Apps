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

        // Kirim filter kategori ke service
        $beritas = $this->beritaService->getAllPaginated(10, $kategoriId);

        // Ambil semua kategori khusus 'berita'
        $kategoris = Kategori::where('sub_kategori', 'berita')->get();

        return view('berita.index', compact('beritas', 'kategoris'));
    }

    public function show($id)
    {
        $berita = $this->beritaService->findById($id);

        $beritaTerkait = $this->beritaService->getBeritaTerkait($berita->kategori_id, $berita->id);

        return view('berita.show', compact('berita', 'beritaTerkait'));
    }

    public function homepageLatestNews() // <--- METODE INI HARUS DITAMBAHKAN
    {
        // Menggunakan service untuk mendapatkan 3 berita terbaru
        $beritas = $this->beritaService->getLatest(3);

        // View untuk halaman beranda Anda (welcome.blade.php)
        return view('welcome', compact('beritas'));
    }
}
