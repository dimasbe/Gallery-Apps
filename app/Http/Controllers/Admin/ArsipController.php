<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// use App\Models\Arsip; // Komen atau hapus ini jika belum ada modelnya

class ArsipController extends Controller
{
    /**
     * Data dummy arsip. Dalam aplikasi nyata, ini akan diambil dari database.
     */
    private function getDummyArsipData()
    {
        return [
            ['id' => 1, 'nama_aplikasi' => 'Mobile Legend', 'pemilik' => 'Stevia Magdalena', 'kategori' => 'Permainan', 'tanggal' => '06 - 05 - 2025', 'deskripsi' => 'Aplikasi game mobile bergenre MOBA yang sangat populer.'],
            ['id' => 2, 'nama_aplikasi' => 'WhatsApp', 'pemilik' => 'Meta Platforms', 'kategori' => 'Komunikasi', 'tanggal' => '10 - 04 - 2025', 'deskripsi' => 'Aplikasi pesan instan untuk komunikasi pribadi dan grup.'],
            ['id' => 3, 'nama_aplikasi' => 'Instagram', 'pemilik' => 'Meta Platforms', 'kategori' => 'Sosial Media', 'tanggal' => '15 - 03 - 2025', 'deskripsi' => 'Platform berbagi foto dan video dengan berbagai fitur kreatif.'],
            ['id' => 4, 'nama_aplikasi' => 'TikTok', 'pemilik' => 'ByteDance', 'kategori' => 'Hiburan', 'tanggal' => '20 - 02 - 2025', 'deskripsi' => 'Aplikasi video pendek yang sangat viral dan menghibur.'],
            ['id' => 5, 'nama_aplikasi' => 'Shopee', 'pemilik' => 'Sea Group', 'kategori' => 'E-commerce', 'tanggal' => '25 - 01 - 2025', 'deskripsi' => 'Platform belanja online terbesar di Asia Tenggara.'],
            ['id' => 6, 'nama_aplikasi' => 'Gojek', 'pemilik' => 'GoTo Group', 'kategori' => 'Transportasi & Layanan', 'tanggal' => '01 - 01 - 2025', 'deskripsi' => 'Aplikasi multi-layanan untuk transportasi, pesan antar, dan pembayaran.'],
            ['id' => 7, 'nama_aplikasi' => 'Spotify', 'pemilik' => 'Spotify AB', 'kategori' => 'Musik', 'tanggal' => '05 - 12 - 2024', 'deskripsi' => 'Layanan streaming musik dengan jutaan lagu dan podcast.'],
            ['id' => 8, 'nama_aplikasi' => 'Netflix', 'pemilik' => 'Netflix, Inc.', 'kategori' => 'Hiburan', 'tanggal' => '10 - 11 - 2024', 'deskripsi' => 'Platform streaming film dan serial TV populer.'],
            ['id' => 9, 'nama_aplikasi' => 'Zoom', 'pemilik' => 'Zoom Video Communications', 'kategori' => 'Komunikasi', 'tanggal' => '15 - 10 - 2024', 'deskripsi' => 'Aplikasi konferensi video untuk rapat online dan webinar.'],
            ['id' => 10, 'nama_aplikasi' => 'CapCut', 'pemilik' => 'ByteDance', 'kategori' => 'Editing Video', 'tanggal' => '20 - 09 - 2024', 'deskripsi' => 'Aplikasi editing video mobile yang mudah digunakan dan kaya fitur.'],
        ];
    }

    /**
     * Menampilkan daftar arsip.
     */
    public function index(Request $request)
    {
        $arsip = $this->getDummyArsipData();

        // Tambahkan 'id' ke setiap item jika belum ada (untuk konsistensi dengan route show)
        // Ini hanya untuk data dummy yang belum memiliki ID
        foreach ($arsip as $key => &$item) {
            if (!isset($item['id'])) {
                $item['id'] = $key + 1; // Memberikan ID sederhana
            }
        }

        return view('admin.arsip.index', compact('arsip'));
    }

    /**
     * Menampilkan arsip tertentu.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $allArsip = $this->getDummyArsipData();
        $arsip = null;

        // Cari arsip berdasarkan ID di data dummy
        foreach ($allArsip as $item) {
            if ($item['id'] == $id) {
                $arsip = $item;
                break;
            }
        }

        // Jika arsip tidak ditemukan, Anda bisa mengarahkan ke halaman 404 atau daftar arsip
        if (!$arsip) {
            // Contoh: Kembali ke daftar arsip dengan pesan error
            return redirect()->route('admin.arsip.index')->with('error', 'Arsip tidak ditemukan.');
            // Atau Anda bisa menampilkan halaman 404
            // abort(404);
        }

        return view('admin.arsip.detail', compact('arsip'));
    }

    // Anda juga perlu metode create(), store(), edit(), update(), destroy()
    // jika Anda menggunakan Route::resource() secara penuh dan ingin fungsionalitas CRUD lengkap.
    // Untuk saat ini, saya hanya menambahkan show().

    /**
     * Menampilkan formulir untuk membuat arsip baru.
     */
    public function create()
    {
        // return view('admin.arsip.create');
    }

    /**
     * Menyimpan arsip baru ke database.
     */
    public function store(Request $request)
    {
        // Logika penyimpanan data
        // return redirect()->route('admin.arsip.index')->with('success', 'Arsip berhasil ditambahkan.');
    }

    /**
     * Menampilkan formulir untuk mengedit arsip yang ditentukan.
     */
    public function edit($id)
    {
        // $arsip = Arsip::findOrFail($id);
        // return view('admin.arsip.edit', compact('arsip'));
    }

    /**
     * Memperbarui arsip yang ditentukan di database.
     */
    public function update(Request $request, $id)
    {
        // Logika pembaruan data
        // return redirect()->route('admin.arsip.index')->with('success', 'Arsip berhasil diperbarui.');
    }

    /**
     * Menghapus arsip yang ditentukan dari database.
     */
    public function destroy($id)
    {
        // Logika penghapusan data
        // return redirect()->route('admin.arsip.index')->with('success', 'Arsip berhasil dihapus.');
    }
}
