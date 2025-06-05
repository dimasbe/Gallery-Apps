<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Berita; // Mungkin tidak lagi diperlukan langsung di sini setelah service
use App\Models\Kategori; // Tetap diperlukan untuk form
use App\Models\FotoBerita; // Tetap diperlukan untuk manipulasi foto langsung
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Services\BeritaService; // <-- Tambahkan ini

class BeritaController extends Controller
{
    protected $beritaService; // <-- Tambahkan properti service

    // Injeksi BeritaService melalui konstruktor
    public function __construct(BeritaService $beritaService)
    {
        $this->beritaService = $beritaService;
    }

    /**
     * Menampilkan daftar berita untuk halaman admin.
     */
    public function index(Request $request) // Tambahkan Request jika ada filter/search
    {
        // Menggunakan BeritaService untuk mendapatkan semua berita dengan paginasi
        // Anda bisa menambahkan parameter 'perPage' jika ingin mengontrol jumlah item per halaman
        // Anda juga bisa menambahkan filter kategori jika ada di UI admin Anda
        $beritas = $this->beritaService->getAllPaginated(10, $request->query('kategori')); // Contoh: 10 item per halaman

        return view('admin.berita.index', compact('beritas'));
    }

    public function uploadCkeditorImage(Request $request)
    {
        if ($request->hasFile('upload')) {
            $file = $request->file('upload');
            $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $path = 'berita/ckeditor/'; // Define your storage path within 'public' disk

            // Store the file in public/berita/ckeditor/
            $file->storeAs('public/' . $path, $fileName);

            // Get the URL for the stored file
            $url = Storage::url($path . $fileName);

            // CKEditor expects a JSON response with a 'url' property
            return response()->json(['url' => $url]);
        }

        // Return an error if no file was uploaded or if something went wrong
        return response()->json(['error' => ['message' => 'Upload failed.']], 400);
    }

    /**
     * Menampilkan form untuk membuat berita baru.
     */
    public function create()
    {
        // Ambil kategori dengan sub_kategori 'berita' saja
        // Anda bisa memindahkan ini ke KategoriService jika ada.
        $kategoris = Kategori::where('sub_kategori', 'berita')->get();
        return view('admin.berita.create', compact('kategoris'));
    }

    /**
     * Menyimpan berita baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul_berita' => 'required|string|max:255',
            'penulis' => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategori,id',
            'thumbnail' => 'required|image|max:2048',
            'keterangan_thumbnail' => 'nullable|string|max:255',
            'isi_berita' => 'required|string', // CKEditor content will be HTML
        ]);

        DB::beginTransaction();

        try {
            // Menggunakan BeritaService untuk membuat berita
            $berita = $this->beritaService->createBerita(
                $request->only([
                    'judul_berita',
                    'penulis',
                    'isi_berita',
                    'kategori_id', // Pastikan kategori_id di-handle di createBerita service
                ]),
                $request->file('thumbnail')
            );

            DB::commit();

            return redirect()->route('admin.berita.index')->with('success', 'Berita berhasil ditambahkan');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan saat menambahkan berita: ' . $e->getMessage());
        }
    }

    /**
     * Menampilkan detail berita tertentu.
     */
    public function show($id) // Parameter diubah menjadi $id untuk konsistensi dengan findById service
    {
        // Menggunakan BeritaService untuk menemukan berita berdasarkan ID
        $berita = $this->beritaService->findById($id);
        return view('admin.berita.show', compact('berita'));
    }

    /**
     * Menampilkan form untuk mengedit berita tertentu.
     */
    public function edit($id) // Parameter diubah menjadi $id
    {
        // Menggunakan BeritaService untuk menemukan berita
        $berita = $this->beritaService->findById($id);

        // Ambil kategori dengan sub_kategori 'berita' saja
        // Ini mungkin bisa di KategoriService juga
        $kategoris = Kategori::where('sub_kategori', 'berita')->get();
        $selectedKategoriId = $berita->kategori_id;

        return view('admin.berita.edit', compact('berita', 'kategoris', 'selectedKategoriId'));
    }

    /**
     * Memperbarui berita tertentu di database.
     */
    public function update(Request $request, $id) // Parameter diubah menjadi $id
    {
        // Validasi input
        $request->validate([
            'judul_berita' => 'required|string|max:255',
            'penulis' => 'required|string|max:255',
            'isi_berita' => 'required|string',
            'kategori_id' => 'required|exists:kategori,id',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'keterangan_thumbnail' => 'nullable|string|max:255',
        ]);

        DB::beginTransaction();

        try {
            // Mengambil instance berita yang akan diupdate
            $berita = $this->beritaService->findById($id);
            if (!$berita) {
                return redirect()->back()->with('error', 'Berita tidak ditemukan.');
            }

            // Menggunakan BeritaService untuk memperbarui berita
            $this->beritaService->updateBerita(
                $berita, // Teruskan instance berita yang sudah ditemukan
                $request->only([
                    'judul_berita',
                    'penulis',
                    'isi_berita',
                    'kategori_id',
                    'keterangan_thumbnail' // Ini perlu di-handle di service jika ada
                ]),
                $request->file('thumbnail')
            );

            DB::commit();

            return redirect()->route('admin.berita.index')->with('success', 'Berita berhasil diperbarui!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan saat memperbarui berita: ' . $e->getMessage());
        }
    }

    /**
     * Menghapus berita tertentu dari database.
     */
    public function destroy($id) // Parameter diubah menjadi $id
    {
        DB::beginTransaction();

        try {
            // Mengambil instance berita yang akan dihapus
            $berita = $this->beritaService->findById($id);
            if (!$berita) {
                return redirect()->back()->with('error', 'Berita tidak ditemukan.');
            }

            // Menggunakan BeritaService untuk menghapus berita
            $this->beritaService->deleteBerita($berita);

            DB::commit();

            return redirect()->route('admin.berita.index')->with('success', 'Berita berhasil dihapus!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus berita: ' . $e->getMessage());
        }
    }
}