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
        $perPage = $request->query('perPage', 5); // Ambil nilai row per page

        // Ubah ini untuk memanggil metode yang ada di BeritaService
        // Anda harus memutuskan apakah Anda ingin menggunakan getAllWithKategori atau
        // menambahkan getAllPaginated ke service seperti di Opsi 1.

        // Jika Anda menggunakan getAllWithKategori, Anda mungkin perlu mengubahnya di Service
        // agar bisa menerima kategoriId juga atau mengelola logika filter kategori di Controller.
        // Untuk kesederhanaan, mari kita asumsikan Anda akan memfilter dengan keyword untuk saat ini,
        // atau tambahkan parameter kategoriId ke getAllWithKategori di service.

        // Contoh jika Anda menganggap 'search' adalah keyword dan ingin menggunakannya:
        $beritas = $this->beritaService->getAllWithKategori($perPage, $search);

        // Jika Anda ingin memfilter berdasarkan kategori_id juga, Anda harus memodifikasi
        // metode getAllWithKategori di service atau menambahkan metode baru.
        // Sebagai contoh, jika Anda menambahkan parameter kategoriId ke getAllWithKategori:
        // $beritas = $this->beritaService->getAllWithKategori($perPage, $search, $kategoriId);


        $kategoris = Kategori::where('sub_kategori', 'berita')->get();

        return view('berita.index', compact('beritas', 'kategoris'));
    }
}
