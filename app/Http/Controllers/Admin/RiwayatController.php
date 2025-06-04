<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Aplikasi;

class RiwayatController extends Controller
{
    /**
     * Menampilkan halaman daftar riwayat aplikasi yang telah diverifikasi.
     */
    public function index()
    {
        // Ambil data berdasarkan status
        $riwayatData = [
            'diterima' => Aplikasi::where('status_verifikasi', 'diterima')
                                  ->where('arsip', false)
                                  ->orderByDesc('tanggal_verifikasi')
                                  ->get(),

            'ditolak' => Aplikasi::where('status_verifikasi', 'ditolak')
                                 ->where('arsip', false)
                                 ->orderByDesc('tanggal_verifikasi')
                                 ->get(),

            'arsip' => Aplikasi::where('arsip', true)
                               ->orderByDesc('tanggal_verifikasi')
                               ->get(),
        ];

        // Untuk loop tab
        $loopStatuses = array_keys($riwayatData); // ['diterima', 'ditolak', 'arsip']

        return view('admin.riwayat.index', compact('riwayatData', 'loopStatuses'));
    }

    /**
     * Menampilkan detail aplikasi berdasarkan ID (yang telah diverifikasi atau diarsipkan).
     */
    public function show($id)
    {
        $aplikasi = Aplikasi::where(function ($query) {
                                $query->whereIn('status_verifikasi', ['diterima', 'ditolak'])
                                      ->orWhere('arsip', true);
                            })
                            ->where('id', $id)
                            ->first();

        if (!$aplikasi) {
            return redirect()->route('riwayat.index')->with('error', 'Data riwayat tidak ditemukan.');
        }

        return view('admin.riwayat.detail', compact('aplikasi'));
    }
}