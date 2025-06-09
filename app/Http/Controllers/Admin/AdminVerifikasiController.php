<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Aplikasi;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon; // Import Carbon untuk tanggal

class AdminVerifikasiController extends Controller
{
    /**
     * Menampilkan daftar aplikasi yang perlu diverifikasi.
     */
    public function index()
    {
        // Ambil aplikasi dengan status_verifikasi 'pending'
        $aplikasi = Aplikasi::where('status_verifikasi', 'pending')->get();
        // return dd(count($aplikasi));
        return view('admin.verifikasi.index', compact('aplikasi'));
    }

    /**
     * Memproses penerimaan aplikasi.
     */
    public function terima(Request $request, $id)
    {
        try {
            $aplikasi = Aplikasi::findOrFail($id);
            
            $aplikasi->update([
                'status_verifikasi' => 'diterima', // Gunakan nilai enum 'diterima'
                'tanggal_verifikasi' => Carbon::now() // Set tanggal verifikasi
            ]);
            return redirect()->route('admin.riwayat.index')->with('success', 'Aplikasi berhasil diterima.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menerima aplikasi: ' . $e->getMessage());
        }
    }

    /**
     * Memproses penolakan aplikasi.
     */
    public function tolak(Request $request, $id)
    {
        try {
            $request->validate([
                'alasan_penolakan' => 'required|string|max:255', // Ganti 'catatan_penolakan'
            ], [
                'alasan_penolakan.required' => 'Alasan penolakan wajib diisi.',
                'alasan_penolakan.string' => 'Alasan penolakan harus berupa teks.',
                'alasan_penolakan.max' => 'Alasan penolakan tidak boleh lebih dari 255 karakter.',
            ]);

            $aplikasi = Aplikasi::findOrFail($id);

            $aplikasi->update([
                'status_verifikasi' => 'ditolak', // Gunakan nilai enum 'ditolak'
                'alasan_penolakan' => $request->alasan_penolakan, // Ganti 'catatan_penolakan'
                'tanggal_verifikasi' => Carbon::now() // Set tanggal verifikasi
            ]);

            return redirect()->route('admin.riwayat.index')->with('success', 'Aplikasi berhasil ditolak.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menolak aplikasi: ' . $e->getMessage());
        }
    }

    public function detailVerifikasi($id) { 
        $aplikasi = Aplikasi::with('user', 'kategori')->find($id)->first();

        // return dd($aplikasi);

        return view('admin.verifikasi.detail', compact('aplikasi'));
    }
}