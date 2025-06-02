<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use App\Models\Kategori;
use App\Models\FotoBerita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB; // Import DB facade untuk transaksi

class BeritaController extends Controller
{
    /**
     * Menampilkan daftar berita.
     */
    public function index()
    {
        // Ambil semua berita dengan eager loading fotoBeritas untuk thumbnail
        $beritas = Berita::with(['fotoBeritas' => function($query) {
            $query->where('tipe', 'thumbnail');
        }])->latest('tanggal_dibuat')->get();

        return view('admin.berita.index', compact('beritas'));
    }

    /**
     * Menampilkan form untuk membuat berita baru.
     */
    public function create()
    {
        // Ambil kategori dengan sub_kategori 'berita' saja
        $kategoris = Kategori::where('sub_kategori', 'berita')->get();
        return view('admin.berita.create', compact('kategoris'));
    }

    /**
     * Menyimpan berita baru ke database.
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'judul_berita' => 'required|string|max:255',
            'penulis' => 'required|string|max:255',
            'isi_berita' => 'required|string',
            'kategori_ids' => 'required|array',
            'kategori_ids.*' => 'exists:kategori,id',
            'thumbnail' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'nama_gambar_tambahan.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'keterangan_gambar_tambahan.*' => 'nullable|string|max:255',
        ]);

        DB::beginTransaction(); // Mulai transaksi database

        try {
            // Buat berita baru
            $berita = Berita::create([
                'judul_berita' => $request->judul_berita,
                'penulis' => $request->penulis,
                'isi_berita' => $request->isi_berita,
                // tanggal_dibuat dan tanggal_diedit akan diisi otomatis oleh database
            ]);

            // Simpan thumbnail
            if ($request->hasFile('thumbnail')) {
                $thumbnailPath = $request->file('thumbnail')->store('public/berita_images');
                FotoBerita::create([
                    'berita_id' => $berita->id,
                    'nama_gambar' => str_replace('public/', '', $thumbnailPath),
                    'keterangan_gambar' => 'Thumbnail untuk ' . $request->judul_berita,
                    'tipe' => 'thumbnail',
                ]);
            }

            // Simpan gambar tambahan jika ada
            if ($request->hasFile('nama_gambar_tambahan')) {
                foreach ($request->file('nama_gambar_tambahan') as $key => $image) {
                    $imagePath = $image->store('public/berita_images');
                    FotoBerita::create([
                        'berita_id' => $berita->id,
                        'nama_gambar' => str_replace('public/', '', $imagePath),
                        'keterangan_gambar' => $request->keterangan_gambar_tambahan[$key] ?? null,
                        'tipe' => 'tambahan',
                    ]);
                }
            }

            // Lampirkan kategori ke berita
            $berita->kategoris()->attach($request->kategori_ids);

            DB::commit(); // Commit transaksi

            return redirect()->route('admin.berita.index')->with('success', 'Berita berhasil ditambahkan!');

        } catch (\Exception $e) {
            DB::rollBack(); // Rollback transaksi jika terjadi error
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan saat menambahkan berita: ' . $e->getMessage());
        }
    }

    /**
     * Menampilkan detail berita tertentu.
     */
    public function show(Berita $berita)
    {
        // Eager load fotoBeritas dan kategoris
        $berita->load('fotoBeritas', 'kategoris');
        return view('admin.berita.show', compact('berita'));
    }

    /**
     * Menampilkan form untuk mengedit berita tertentu.
     */
    public function edit(Berita $berita)
    {
        // Eager load fotoBeritas dan kategoris
        $berita->load('fotoBeritas', 'kategoris');
        // Ambil kategori dengan sub_kategori 'berita' saja
        $kategoris = Kategori::where('sub_kategori', 'berita')->get();
        // Ambil ID kategori yang sudah terpilih untuk berita ini
        $selectedKategoris = $berita->kategoris->pluck('id')->toArray();

        return view('admin.berita.edit', compact('berita', 'kategoris', 'selectedKategoris'));
    }

    /**
     * Memperbarui berita tertentu di database.
     */
    public function update(Request $request, Berita $berita)
    {
        // Validasi input
        $request->validate([
            'judul_berita' => 'required|string|max:255',
            'penulis' => 'required|string|max:255',
            'isi_berita' => 'required|string',
            'kategori_ids' => 'required|array',
            'kategori_ids.*' => 'exists:kategori,id',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'nama_gambar_tambahan.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'keterangan_gambar_tambahan.*' => 'nullable|string|max:255',
        ]);

        DB::beginTransaction(); // Mulai transaksi database

        try {
            // Update data berita
            $berita->update([
                'judul_berita' => $request->judul_berita,
                'penulis' => $request->penulis,
                'isi_berita' => $request->isi_berita,
                // tanggal_diedit akan diupdate otomatis oleh database
            ]);

            // Update thumbnail jika ada yang baru
            if ($request->hasFile('thumbnail')) {
                // Hapus thumbnail lama jika ada
                $oldThumbnail = $berita->fotoBeritas()->where('tipe', 'thumbnail')->first();
                if ($oldThumbnail) {
                    Storage::delete('public/' . $oldThumbnail->nama_gambar);
                    $oldThumbnail->delete();
                }

                $thumbnailPath = $request->file('thumbnail')->store('public/berita_images');
                FotoBerita::create([
                    'berita_id' => $berita->id,
                    'nama_gambar' => str_replace('public/', '', $thumbnailPath),
                    'keterangan_gambar' => 'Thumbnail untuk ' . $request->judul_berita,
                    'tipe' => 'thumbnail',
                ]);
            }

            // Hapus gambar tambahan yang dihapus (jika ada input hidden untuk ID gambar yang dihapus)
            if ($request->has('deleted_image_ids')) {
                $deletedImageIds = json_decode($request->deleted_image_ids);
                foreach ($deletedImageIds as $imageId) {
                    $foto = FotoBerita::find($imageId);
                    if ($foto && $foto->berita_id === $berita->id) {
                        Storage::delete('public/' . $foto->nama_gambar);
                        $foto->delete();
                    }
                }
            }

            // Tambahkan gambar tambahan baru jika ada
            if ($request->hasFile('nama_gambar_tambahan')) {
                foreach ($request->file('nama_gambar_tambahan') as $key => $image) {
                    $imagePath = $image->store('public/berita_images');
                    FotoBerita::create([
                        'berita_id' => $berita->id,
                        'nama_gambar' => str_replace('public/', '', $imagePath),
                        'keterangan_gambar' => $request->keterangan_gambar_tambahan[$key] ?? null,
                        'tipe' => 'tambahan',
                    ]);
                }
            }

            // Sinkronkan kategori
            $berita->kategoris()->sync($request->kategori_ids);

            DB::commit(); // Commit transaksi

            return redirect()->route('admin.berita.index')->with('success', 'Berita berhasil diperbarui!');

        } catch (\Exception $e) {
            DB::rollBack(); // Rollback transaksi jika terjadi error
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan saat memperbarui berita: ' . $e->getMessage());
        }
    }

    /**
     * Menghapus berita tertentu dari database.
     */
    public function destroy(Berita $berita)
    {
        DB::beginTransaction(); // Mulai transaksi database

        try {
            // Hapus semua foto terkait dari storage
            foreach ($berita->fotoBeritas as $foto) {
                Storage::delete('public/' . $foto->nama_gambar);
            }

            // Hapus berita (ini juga akan menghapus fotoBeritas karena onDelete('cascade'))
            $berita->delete();

            DB::commit(); // Commit transaksi

            return redirect()->route('admin.berita.index')->with('success', 'Berita berhasil dihapus!');

        } catch (\Exception $e) {
            DB::rollBack(); // Rollback transaksi jika terjadi error
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus berita: ' . $e->getMessage());
        }
    }
}
