<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use App\Models\Kategori;
use App\Models\FotoBerita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

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
            // Simpan berita
            $berita = Berita::create([
                'judul_berita' => $request->judul_berita,
                'penulis' => $request->penulis,
                'isi_berita' => $request->isi_berita, // Directly use the HTML content from CKEditor
                'tanggal_dibuat' => now(),
                'tanggal_diedit' => now(),
            ]);

            // Sync categories (assuming a many-to-many relationship through a pivot table)
            // If it's a one-to-many, you'd set kategori_id directly on the Berita model.
            // Based on your current migration, kategori_id is on Berita, so we'll update that.
            $berita->kategori_id = $request->kategori_id;
            $berita->save();


            // Simpan thumbnail
            if ($request->hasFile('thumbnail')) {
                $path = $request->file('thumbnail')->store('berita/thumbnails', 'public'); // Store in public/berita/thumbnails
                FotoBerita::create([
                    'berita_id' => $berita->id,
                    'nama_gambar' => str_replace('public/', '', $path), // Store path without 'public/' prefix
                    'keterangan_gambar' => $request->keterangan_thumbnail,
                    'tipe' => 'thumbnail',
                ]);
            }

            // Note: Additional images for the content itself are handled by CKEditor's uploadCkeditorImage
            // and are embedded directly in the isi_berita HTML. You don't need to save them separately here.

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
    public function show(Berita $berita)
    {
        // Eager load fotoBeritas dan kategoris
        $berita->load('fotoBeritas', 'kategori'); // Assuming one-to-many with 'kategori'
        return view('admin.berita.show', compact('berita'));
    }

    /**
     * Menampilkan form untuk mengedit berita tertentu.
     */
    public function edit(Berita $berita)
    {
        // Eager load fotoBeritas and kategori
        $berita->load('fotoBeritas', 'kategori');
        // Ambil kategori dengan sub_kategori 'berita' saja
        $kategoris = Kategori::where('sub_kategori', 'berita')->get();
        // Ambil ID kategori yang sudah terpilih untuk berita ini
        $selectedKategoriId = $berita->kategori_id; // For one-to-many

        return view('admin.berita.edit', compact('berita', 'kategoris', 'selectedKategoriId'));
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
            'kategori_id' => 'required|exists:kategori,id', // For one-to-many
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'keterangan_thumbnail' => 'nullable|string|max:255',
        ]);

        DB::beginTransaction();

        try {
            // Update data berita
            $berita->update([
                'judul_berita' => $request->judul_berita,
                'penulis' => $request->penulis,
                'isi_berita' => $request->isi_berita,
                'kategori_id' => $request->kategori_id, // For one-to-many
                // tanggal_diedit akan diupdate otomatis oleh database
            ]);

            // Update thumbnail if a new one is provided
            if ($request->hasFile('thumbnail')) {
                // Hapus thumbnail lama jika ada
                $oldThumbnail = $berita->fotoBeritas()->where('tipe', 'thumbnail')->first();
                if ($oldThumbnail) {
                    Storage::delete('public/' . $oldThumbnail->nama_gambar);
                    $oldThumbnail->delete();
                }

                $thumbnailPath = $request->file('thumbnail')->store('berita/thumbnails', 'public');
                FotoBerita::create([
                    'berita_id' => $berita->id,
                    'nama_gambar' => str_replace('public/', '', $thumbnailPath),
                    'keterangan_gambar' => $request->keterangan_thumbnail,
                    'tipe' => 'thumbnail',
                ]);
            } else if ($request->has('keterangan_thumbnail')) {
                // Update caption even if no new image
                $thumbnail = $berita->fotoBeritas()->where('tipe', 'thumbnail')->first();
                if ($thumbnail) {
                    $thumbnail->update(['keterangan_gambar' => $request->keterangan_thumbnail]);
                }
            }


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