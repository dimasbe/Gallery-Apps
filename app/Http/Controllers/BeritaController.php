<?php

namespace App\Http\Controllers;

use App\Services\BeritaService;
use App\Models\Kategori; // Diperlukan untuk metode index()
use App\Models\Berita; // Mengimpor model Berita karena akan digunakan secara langsung untuk increment
use Illuminate\Http\Request;
use Illuminate\View\View; // Mengimpor View class untuk type hinting

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
         $search = $request->query('search');
         $perPage = $request->query('perPage', 5); // Ambil nilai row per page
     
         $beritas = $this->beritaService->getAllPaginated($perPage, $kategoriId, $search);
     
         $kategoris = Kategori::where('sub_kategori', 'berita')->get();
     
         return view('berita.index', compact('beritas', 'kategoris'));
     }
     


    /**
     * Metode ini khusus untuk halaman Utama (homepage) yang menampilkan berita terbaru.
     * Ini adalah metode yang akan merender welcome.blade.php dan menyediakan variable $beritas.
     *
     * @return \Illuminate\View\View
     */
    public function homepageLatestNews(): View // Menambahkan type hinting View
    {
        // Menggunakan service untuk mendapatkan 3 berita terbaru.
        // Metode getAllPaginated(3) di BeritaService akan mengembalikan objek Paginator
        // dengan 3 item per halaman (karena sudah diurutkan 'tanggal_dibuat' secara descending).
        // Kita kemudian mengambil koleksi item dari Paginator tersebut.
        $paginatedBeritas = $this->beritaService->getAllPaginated(3);
        $beritas = $paginatedBeritas->items(); // Mengambil koleksi item (Berita) dari paginator

        // View untuk halaman beranda Anda (welcome.blade.php)
        return view('welcome', compact('beritas'));
    }

    /**
     * Metode ini untuk menampilkan detail satu artikel berita.
     * Contoh: /berita/123
     * @param  int  $id ID berita
     * @return \Illuminate\View\View
     */
    public function show(int $id): View // Menambahkan type hinting int untuk $id dan View untuk return
    {
        // Mengambil berita dari service
        $berita = $this->beritaService->findById($id);

        // --- Logika untuk mengincrement jumlah_kunjungan ---
        // Memastikan model Berita diimpor untuk menggunakan metode increment()
        $berita->increment('jumlah_kunjungan');

        // Mengaktifkan pemanggilan metode getBeritaTerkait dari service
        // dan mengirimkan variable $beritaTerkait ke view
        $beritaTerkait = $this->beritaService->getBeritaTerkait($berita->kategori_id, $berita->id);

        return view('berita.show', compact('berita', 'beritaTerkait'));
    }
}
