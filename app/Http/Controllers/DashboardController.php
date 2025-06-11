<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Models\Berita;
use App\Models\Kategori;
use App\Models\Aplikasi;
use App\Contracts\Interfaces\AplikasiInterface;

class DashboardController extends Controller
{
    protected AplikasiInterface $aplikasiRepository;

    public function __construct(AplikasiInterface $aplikasiRepository)
    {
        $this->aplikasiRepository = $aplikasiRepository;
    }

    public function index()
    {
        if (Auth::check() && Auth::user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        return $this->renderUserDashboard();
    }

    public function welcome()
    {
        $aplikasiPopuler = $this->aplikasiRepository->getPopularApps(6); // ✔️ Sudah sesuai dengan interface
        return view('welcome', compact('aplikasiPopuler'));
    }

    private function renderUserDashboard()
    {
        $beritas = Berita::orderBy('tanggal_dibuat', 'desc')->limit(3)->get();

        $kategoriAplikasi = Kategori::where('sub_kategori', 'aplikasi')
            ->latest()
            ->take(6)
            ->with(['aplikasi' => function ($query) {
                $query->where('status_verifikasi', 'diterima')
                    ->with('fotoUtama')
                    ->select('id', 'id_kategori', 'nama_aplikasi', 'slug')
                    ->latest()
                    ->limit(1);
            }])
            ->get();

        $aplikasiTerbaru = Aplikasi::with('fotoUtama')
            ->where('status_verifikasi', 'diterima')
            ->orderBy('created_at', 'desc')
            ->take(6)
            ->get();

        // ✅ Tambahkan ini
        $aplikasiPopuler = $this->aplikasiRepository->getPopularApps(6);

        return view('dashboard', compact(
            'kategoriAplikasi',
            'beritas',
            'aplikasiTerbaru',
            'aplikasiPopuler' // ← kirim ke blade
        ));
    }


    public function showAplikasi(Aplikasi $aplikasi): View
    {
        $aplikasi->increment('jumlah_kunjungan');
        $aplikasi->load('kategori', 'fotoAplikasi');
        return view('aplikasi.detail', compact('aplikasi'));
    }
}
