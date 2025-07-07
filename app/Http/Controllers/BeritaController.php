<?php

namespace App\Http\Controllers;

use App\Services\BeritaService;
use App\Models\Kategori;
use App\Models\KunjunganBerita;
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

        $beritas = $this->beritaService->getAllPaginated($perPage, $kategoriId, $search);
        $kategoris = Kategori::where('sub_kategori', 'berita')->get();

        return view('berita.index', compact('beritas', 'kategoris'));
    }

    public function show(int $id)
    {
        // Ambil berita
        $berita = $this->beritaService->findById($id);

        // Tambah jumlah_kunjungan
        $berita->increment('jumlah_kunjungan');

        // Catat kunjungan ke tabel kunjungan_beritas
        KunjunganBerita::create([
            'berita_id' => $berita->id,
            'ip_address' => request()->ip(),
            'user_agent' => request()->header('User-Agent'),
            'tanggal_kunjungan' => now(),
        ]);

        // Ambil berita terkait
        $beritaTerkait = $this->beritaService->getBeritaTerkait($berita->kategori_id, $berita->id);
        $kategoris = Kategori::where('sub_kategori', 'berita')->get();

        return view('berita.show', compact('berita', 'beritaTerkait', 'kategoris'));
    }
}
