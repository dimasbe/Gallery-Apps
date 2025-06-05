<?php

namespace App\Http\Controllers;

use App\Services\BeritaService;
use App\Models\Kategori; // Diperlukan untuk metode index()
use Illuminate\Http\Request;
// use App\Models\Berita; // Tidak perlu mengimpor model Berita di sini karena service yang menghandle

class BeritaController extends Controller
{
    protected $beritaService;

    public function __construct(BeritaService $beritaService)
    {
        $this->beritaService = $beritaService;
    }

    /**
     * Metode ini untuk menampilkan daftar berita lengkap dengan paginasi dan filter.
     * Contoh: /berita?kategori=1
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $kategoriId = $request->query('kategori');

        $beritas = $this->beritaService->getAllPaginated(null, $kategoriId);
        $kategoris = Kategori::all(); // Mengambil kategori langsung karena tidak ada service Kategori yang diberikan

        return view('berita.index', compact('beritas', 'kategoris'));
    }

    /**
     * Metode ini khusus untuk halaman utama (homepage) yang menampilkan 3 berita terbaru.
     * Ini adalah metode yang akan merender welcome.blade.php dan menyediakan variabel $beritas.
     *
     * @return \Illuminate\View\View
     */
    public function homepageLatestNews() // <--- METODE INI HARUS DITAMBAHKAN
    {
        // Menggunakan service untuk mendapatkan 3 berita terbaru
        $beritas = $this->beritaService->getLatest(3);

        // View untuk halaman beranda Anda (welcome.blade.php)
        return view('welcome', compact('beritas'));
    }

    /**
     * Metode ini untuk menampilkan detail satu artikel berita.
     * Contoh: /berita/123
     * @param  int  $id ID berita
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $berita = $this->beritaService->findById($id);
        return view('berita.show', compact('berita'));
    }
}