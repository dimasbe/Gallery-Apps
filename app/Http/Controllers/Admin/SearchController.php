<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Berita;
use App\Models\Kategori; // Model ini merujuk ke tabel 'kategori_aplikasi'
use App\Models\Aplikasi;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('q');

        if (!$query) {
            return response()->json([]);
        }

        try {
            // Pencarian di tabel 'users'
            $users = User::where('name', 'like', "%$query%")
                ->orWhere('email', 'like', "%$query%")
                ->limit(5)
                ->get(['id', 'name', 'email']);

            // Pencarian di tabel 'berita' menggunakan 'judul_berita'
            $berita = Berita::where('judul_berita', 'like', "%$query%")
                ->limit(5)
                ->get(['id', 'judul_berita']);

            // Pencarian di tabel 'kategori_aplikasi' (model Kategori) menggunakan 'nama_kategori'
            $kategori = Kategori::where('nama_kategori', 'like', "%$query%")
                ->limit(5)
                ->get(['id', 'nama_kategori']);

            // Pencarian di tabel 'aplikasi' menggunakan 'nama_aplikasi'
            $aplikasi = Aplikasi::where('nama_aplikasi', 'like', "%$query%")
                ->limit(5)
                ->get(['id', 'nama_aplikasi']);

            return response()->json([
                'users' => $users,
                'berita' => $berita,
                'kategori' => $kategori,
                'aplikasi' => $aplikasi, // Menggunakan 'aplikasi' sebagai kunci di respons JSON
            ]);
        } catch (\Exception $e) {
            // Tangkap dan kembalikan error sebagai JSON untuk debugging
            return response()->json([
                'error' => true,
                'message' => 'Terjadi kesalahan internal server: ' . $e->getMessage(),
                'trace' => $e->getTraceAsString() // Sertakan trace untuk debugging lebih lanjut
            ], 500); // Kode status 500 untuk error server
        }
    }
}