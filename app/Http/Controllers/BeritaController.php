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



        // Menggunakan service untuk mendapatkan berita dengan paginasi dan filter kategori

        // Asumsi getAllPaginated() di service bisa menerima null atau nilai default untuk jumlah item per halaman

        $beritas = $this->beritaService->getAllPaginated(10, $kategoriId); // Menggunakan 10 sebagai default per halaman



        // Mengambil semua kategori (bisa juga dari service jika ada service Kategori)

        $kategoris = Kategori::all();



        return view('berita.index', compact('beritas', 'kategoris'));

    }



    /**

     * Metode ini khusus untuk halaman Utama (homepage) yang menampilkan berita terbaru.

     * Ini adalah metode yang akan merender welcome.blade.php dan menyediakan variable $beritas.

     *

     * @return \Illuminate\View\View

     */

    public function homepageLatestNews()

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

    public function show($id)

    {

        $berita = $this->beritaService->findById($id);



        // Mengaktifkan pemanggilan metode getBeritaTerkait dari service

        // dan mengirimkan variable $beritaTerkait ke view

        $beritaTerkait = $this->beritaService->getBeritaTerkait($berita->kategori_id, $berita->id);



        return view('berita.show', compact('berita', 'beritaTerkait'));

    }

}