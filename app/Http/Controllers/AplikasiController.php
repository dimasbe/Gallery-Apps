<?php

namespace App\Http\Controllers;

use App\Contracts\Interfaces\AplikasiInterface;
use App\Contracts\Interfaces\FotoAplikasiInterface;
use App\Contracts\Interfaces\KategoriAplikasiInterface;
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
    private KategoriAplikasiInterface $kategoriAplikasi;
    private FotoAplikasiInterface $fotoAplikasi;

    public function __construct(AplikasiInterface $aplikasi, FotoAplikasiInterface $fotoAplikasi, KategoriAplikasiInterface $kategoriAplikasi) {
        $this->aplikasi = $aplikasi;
        $this->kategoriAplikasi = $kategoriAplikasi;
        $this->fotoAplikasi = $fotoAplikasi;
    }

    public function index(): View {
        $aplikasi = $this->aplikasi->get();
        $kategorisAplikasi = $this->kategoriAplikasi->get();
        $fotoAplikasi = $this->fotoAplikasi->get();
        
        return view('aplikasi.index', compact('aplikasi', 'kategoriAplikasi', 'fotoAplikasi'));
    }

    public function create(): View {
        $aplikasi = $this->aplikasi->get();
        $kategorisAplikasi = $this->kategoriAplikasi->get();
        $fotoAplikasi = $this->fotoAplikasi->get();

        return view('aplikasi.create', compact('kategoriAplikasi'));
    }

    public function store(StoreAplikasiRequest $request): RedirectResponse {
        try {
            $this->aplikasi->store($request->validated());
            Alert::success('Berhasil', 'Aplikasi Berhasil Ditambahkan');
            return redirect()->route('aplikasi.index');
        } catch (\Illuminate\Validation\ValidationException $e) {
            Alert::error('Gagal', 'Silakan periksa kembali form Anda');
            return back()->withErrors($e->validator)->withInput();
        }
    }    

    public function showAplikasi(Aplikasi $aplikasi): View {
        $aplikasi = $this->aplikasi->get();
        $kategorisAplikasi = $this->kategoriAplikasi->get();
        $fotoAplikasi = $this->fotoAplikasi->get();

        return view('aplikasi.index', compact('aplikasi', 'kategoriAplikasi', 'fotoAplikasi'));
    }

    public function edit(Aplikasi $aplikasi): View {
        $aplikasi = $this->aplikasi->get();
        $kategorisAplikasi = $this->kategoriAplikasi->get();
        $fotoAplikasi = $this->fotoAplikasi->get();

        return view('aplikasi.edit', compact('aplikasi', 'kategoriAplikasi', 'fotoAplikasi'));
    }

    public function update(UpdateAplikasiRequest $request, Aplikasi $aplikasi) {
        try {
            $this->aplikasi->update($aplikasi->id, $request->validated());
            Alert::success('Berhasil', 'Aplikasi Berhasil Diperbarui');
            return redirect()->route('aplikasi.index');
        } catch (\Illuminate\Validation\ValidationException $e) {
            Alert::error('Gagal', 'Silakan periksa kembali form Anda');
            return back()->withErrors($e->validator)->withInput();
        }
    }    

    public function destroy(Aplikasi $aplikasi) {
        try {
            $this->aplikasi->delete($aplikasi->id);
            Alert::success('Berhasil', 'Aplikasi Berhasil Dihapus');
            return back();
        } catch (QueryException $e) {
            if ($e->errorInfo[1] == 1451) {
                Alert::error('Gagal', 'Aplikasi Belum Dihapus');
                return to_route('aplikasi.index');
            }
        }
        Alert::success('Berhasil', 'Aplikasi Berhasil Dihapus');
        return redirect()->route('aplikasi.index');
    }
}
                            