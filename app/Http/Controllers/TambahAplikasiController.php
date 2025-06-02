<?php

namespace App\Http\Controllers;

use App\Models\Aplikasi;
use App\Models\FotoAplikasi;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log; // Untuk logging error

class TambahAplikasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Mendapatkan aplikasi yang dimiliki oleh user yang sedang login
        $aplikasi = Aplikasi::where('id_user', Auth::id())->with('kategori', 'fotoAplikasi')->get();
        return view('tambah_aplikasi.index', compact('aplikasi'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Mengambil kategori dengan sub_kategori 'aplikasi' saja
        $kategoris = Kategori::where('sub_kategori', 'aplikasi')->get();
        return view('tambah_aplikasi.create', compact('kategoris'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_aplikasi' => 'required|string|max:255',
            'logo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'id_kategori' => 'required|exists:kategori,id',
            'nama_pemilik' => 'required|string|max:255',
            'tanggal_rilis' => 'required|date',
            'tanggal_update' => 'nullable|date',
            'versi' => 'required|string|max:50',
            'rating_konten' => 'required|string|max:50',
            'tautan_aplikasi' => 'required|url|max:255',
            'deskripsi' => 'required|string',
            'fitur' => 'required|string',
            'foto_aplikasi.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Untuk multiple files
        ]);

        try {
            // Upload Logo
            $logoPath = $request->file('logo')->store('public/aplikasi_logos');
            $logoPath = str_replace('public/', 'storage/', $logoPath); // Untuk akses publik

            // Buat entri Aplikasi
            $aplikasi = Aplikasi::create([
                'id_user' => Auth::id(),
                'nama_aplikasi' => $request->nama_aplikasi,
                'logo' => $logoPath,
                'id_kategori' => $request->id_kategori,
                'nama_pemilik' => $request->nama_pemilik,
                'tanggal_rilis' => $request->tanggal_rilis,
                'tanggal_update' => $request->tanggal_update,
                'versi' => $request->versi,
                'rating_konten' => $request->rating_konten,
                'tautan_aplikasi' => $request->tautan_aplikasi,
                'deskripsi' => $request->deskripsi,
                'fitur' => $request->fitur,
                // Default values for status_verifikasi, arsip, tanggal_ditambahkan handled by migration
            ]);

            // Upload Foto Aplikasi (jika ada)
            if ($request->hasFile('foto_aplikasi')) {
                foreach ($request->file('foto_aplikasi') as $foto) {
                    $fotoPath = $foto->store('public/aplikasi_photos');
                    $fotoPath = str_replace('public/', 'storage/', $fotoPath); // Untuk akses publik
                    FotoAplikasi::create([
                        'id_aplikasi' => $aplikasi->id,
                        'path_foto' => $fotoPath,
                    ]);
                }
            }

            return redirect()->route('user_login.aplikasi.index')->with('success', 'Aplikasi berhasil ditambahkan!');

        } catch (\Exception $e) {
            Log::error('Error storing application: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan saat menambahkan aplikasi. Silakan coba lagi.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Aplikasi $aplikasi)
    {
        // Pastikan aplikasi yang diminta milik user yang sedang login
        if ($aplikasi->id_user !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        $aplikasi->load('kategori', 'fotoAplikasi'); // Load relasi
        return view('tambah_aplikasi.show', compact('aplikasi'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Aplikasi $aplikasi)
    {
        // Pastikan aplikasi yang diminta milik user yang sedang login
        if ($aplikasi->id_user !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        $kategoris = Kategori::where('sub_kategori', 'aplikasi')->get();
        $aplikasi->load('fotoAplikasi'); // Load foto-foto aplikasi
        return view('tambah_aplikasi.edit', compact('aplikasi', 'kategoris'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Aplikasi $aplikasi)
    {
        // Pastikan aplikasi yang diminta milik user yang sedang login
        if ($aplikasi->id_user !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'nama_aplikasi' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'id_kategori' => 'required|exists:kategori,id',
            'nama_pemilik' => 'required|string|max:255',
            'tanggal_rilis' => 'required|date',
            'tanggal_update' => 'nullable|date',
            'versi' => 'required|string|max:50',
            'rating_konten' => 'required|string|max:50',
            'tautan_aplikasi' => 'required|url|max:255',
            'deskripsi' => 'required|string',
            'fitur' => 'required|string',
            'foto_aplikasi.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        try {
            // Update Logo (jika ada file baru diupload)
            if ($request->hasFile('logo')) {
                // Hapus logo lama jika ada
                if ($aplikasi->logo && Storage::exists(str_replace('storage/', 'public/', $aplikasi->logo))) {
                    Storage::delete(str_replace('storage/', 'public/', $aplikasi->logo));
                }
                $logoPath = $request->file('logo')->store('public/aplikasi_logos');
                $aplikasi->logo = str_replace('public/', 'storage/', $logoPath);
            }

            // Update data aplikasi
            $aplikasi->update([
                'nama_aplikasi' => $request->nama_aplikasi,
                'id_kategori' => $request->id_kategori,
                'nama_pemilik' => $request->nama_pemilik,
                'tanggal_rilis' => $request->tanggal_rilis,
                'tanggal_update' => $request->tanggal_update,
                'versi' => $request->versi,
                'rating_konten' => $request->rating_konten,
                'tautan_aplikasi' => $request->tautan_aplikasi,
                'deskripsi' => $request->deskripsi,
                'fitur' => $request->fitur,
            ]);

            // Update Foto Aplikasi (jika ada file baru diupload)
            if ($request->hasFile('foto_aplikasi')) {
                // Hapus semua foto lama terkait aplikasi ini
                foreach ($aplikasi->fotoAplikasi as $foto) {
                    if (Storage::exists(str_replace('storage/', 'public/', $foto->path_foto))) {
                        Storage::delete(str_replace('storage/', 'public/', $foto->path_foto));
                    }
                    $foto->delete();
                }

                // Simpan foto-foto baru
                foreach ($request->file('foto_aplikasi') as $foto) {
                    $fotoPath = $foto->store('public/aplikasi_photos');
                    FotoAplikasi::create([
                        'id_aplikasi' => $aplikasi->id,
                        'path_foto' => str_replace('public/', 'storage/', $fotoPath),
                    ]);
                }
            }

            return redirect()->route('user_login.aplikasi.index')->with('success', 'Aplikasi berhasil diperbarui!');

        } catch (\Exception $e) {
            Log::error('Error updating application: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan saat memperbarui aplikasi. Silakan coba lagi.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Aplikasi $aplikasi)
    {
        // Pastikan aplikasi yang diminta milik user yang sedang login
        if ($aplikasi->id_user !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        try {
            // Hapus logo
            if ($aplikasi->logo && Storage::exists(str_replace('storage/', 'public/', $aplikasi->logo))) {
                Storage::delete(str_replace('storage/', 'public/', $aplikasi->logo));
            }

            // Hapus foto-foto terkait
            foreach ($aplikasi->fotoAplikasi as $foto) {
                if (Storage::exists(str_replace('storage/', 'public/', $foto->path_foto))) {
                    Storage::delete(str_replace('storage/', 'public/', $foto->path_foto));
                }
                $foto->delete(); // Hapus entri dari database
            }

            $aplikasi->delete(); // Hapus entri aplikasi dari database

            return redirect()->route('user_login.aplikasi.index')->with('success', 'Aplikasi berhasil dihapus!');

        } catch (\Exception $e) {
            Log::error('Error deleting application: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus aplikasi. Silakan coba lagi.');
        }
    }
}