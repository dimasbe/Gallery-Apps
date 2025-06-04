<?php

namespace App\Http\Controllers;

use App\Contracts\Interfaces\AplikasiInterface;
use App\Contracts\Interfaces\FotoAplikasiInterface;
use App\Contracts\Interfaces\KategoriInterface;
use App\Http\Requests\StoreAplikasiRequest;
use App\Http\Requests\UpdateAplikasiRequest;
use App\Models\Aplikasi;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use RealRashid\SweetAlert\Facades\Alert;

class AplikasiController extends Controller
{
    private AplikasiInterface $aplikasi;
    private KategoriInterface $kategoriAplikasi;
    private FotoAplikasiInterface $fotoAplikasi;

    public function __construct(AplikasiInterface $aplikasi, FotoAplikasiInterface $fotoAplikasi, KategoriInterface $kategoriAplikasi)
    {
        $this->aplikasi = $aplikasi;
        $this->kategoriAplikasi = $kategoriAplikasi;
        $this->fotoAplikasi = $fotoAplikasi;
    }

    public function index(): View
    {
        $aplikasi = $this->aplikasi->get();
        $kategorisAplikasi = $this->kategoriAplikasi->get();
        $fotoAplikasi = $this->fotoAplikasi->get();

        return view('aplikasi.index', compact('aplikasi', 'kategorisAplikasi', 'fotoAplikasi'));
    }

    public function create(): View
    {
        $kategorisAplikasi = $this->kategoriAplikasi->get();

        return view('aplikasi.create', compact('kategorisAplikasi'));
    }

    public function store(StoreAplikasiRequest $request): RedirectResponse
    {
        try {
            $this->aplikasi->store($request->validated());
            Alert::success('Berhasil', 'Aplikasi Berhasil Ditambahkan');
            return redirect()->route('aplikasi.index');
        } catch (\Illuminate\Validation\ValidationException $e) {
            Alert::error('Gagal', 'Silakan periksa kembali form Anda');
            return back()->withErrors($e->validator)->withInput();
        }
    }

    public function show(Aplikasi $aplikasi): View
    {
        // Mengambil detail aplikasi berdasarkan ID
        return view('aplikasi.detail', compact('aplikasi'));
    }

    public function edit(Aplikasi $aplikasi): View
    {
        $kategorisAplikasi = $this->kategoriAplikasi->get();
        $fotoAplikasi = $this->fotoAplikasi->get();

        return view('aplikasi.edit', compact('aplikasi', 'kategorisAplikasi', 'fotoAplikasi'));
    }

    public function update(UpdateAplikasiRequest $request, Aplikasi $aplikasi): RedirectResponse
    {
        try {
            $this->aplikasi->update($aplikasi->id, $request->validated());
            Alert::success('Berhasil', 'Aplikasi Berhasil Diperbarui');
            return redirect()->route('aplikasi.index');
        } catch (\Illuminate\Validation\ValidationException $e) {
            Alert::error('Gagal', 'Silakan periksa kembali form Anda');
            return back()->withErrors($e->validator)->withInput();
        }
    }

    public function destroy(Aplikasi $aplikasi): RedirectResponse
    {
        try {
            $this->aplikasi->delete($aplikasi->id);
            Alert::success('Berhasil', 'Aplikasi Berhasil Dihapus');
            return redirect()->route('aplikasi.index');
        } catch (QueryException $e) {
            if ($e->errorInfo[1] == 1451) {
                Alert::error('Gagal', 'Aplikasi Belum Dihapus karena masih terhubung dengan data lain');
                return redirect()->route('aplikasi.index');
            }
        }
        Alert::success('Berhasil', 'Aplikasi Berhasil Dihapus');
        return redirect()->route('aplikasi.index');
    }

    public function search(Request $request): View
    {
        $aplikasi = $this->aplikasi->search($request);
        return view('aplikasi.search', compact('aplikasi'));
    }
}
