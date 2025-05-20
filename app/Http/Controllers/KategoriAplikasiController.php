<?php

namespace App\Http\Controllers;

use App\Contracts\Interfaces\KategoriAplikasiInterface;
use App\Http\Requests\StoreKategoriAplikasiRequest;
use App\Http\Requests\UpdateKategoriAplikasiRequest;
use App\Models\KategoriAplikasi;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use RealRashid\SweetAlert\Facades\Alert;

class KategoriAplikasiController extends Controller
{
    private KategoriAplikasiInterface $kategoriAplikasi;

    public function __construct(KategoriAplikasiInterface $kategoriAplikasi) {
        $this->kategoriAplikasi = $kategoriAplikasi;
    }

    public function index(): View {
        $kategoriAplikasi = $this->kategoriAplikasi->get();

        return view('admin.kategoriaplikasi.index', compact('kategoriAplikasi'));
    }

    public function create(): View {
        return view('admin.kategoriaplikasi.create');
    }

    public function store(StoreKategoriAplikasiRequest $request) : RedirectResponse {
        try {
            $this->kategoriAplikasi->store($request->validated());
            Alert::success('Berhasil', 'Kategori Berhasil Ditambahkan');
            return redirect()->route('admin.kategoriaplikasi.index');
        } catch (\Illuminate\Validation\ValidationException $e) {
            Alert::error('Gagal', 'Silakan periksa kembali form Anda');
            return back()->withErrors($e->validator)->withInput();
        }
    }

    public function showKategori(KategoriAplikasi $kategoriAplikasi): View {
        $kategoriAplikasi = $this->kategoriAplikasi->get();
        return view('admin.kategoriaplikasi.index', compact('kategoriAplikasi'));
    }

    public function edit(KategoriAplikasi $kategoriAplikasi): View {
        return view('admin.kategoriaplikasi.edit', compact('kategoriaplikasi'));
    }

    public function update(UpdateKategoriAplikasiRequest $request, KategoriAplikasi $kategoriAplikasi) {
        try {
            $this->kategoriAplikasi->update($kategoriAplikasi->id, $request->validated());
            Alert::success('Berhasil', 'Kategori Berhasil Diperbarui');
            return redirect()->route('admin.kategoriaplikasi.index');
        } catch (\Illuminate\Validation\ValidationException $e) {
            Alert::error('Gagal', 'Silakan periksa kembali form Anda');
            return back()->withErrors($e->validator)->withInput();
        }
    }    

    public function destroy(KategoriAplikasi $kategoriAplikasi) {
        try {
            $this->kategoriAplikasi->delete($kategoriAplikasi->id);
            Alert::success('Berhasil', 'Kategori Berhasil Dihapus');
            return back();
        } catch (QueryException $e) {
            if ($e->errorInfo[1] == 1451) {
                Alert::error('Gagal', 'Kategori Belum Dihapus');
                return to_route('admin.kategoriaplikasi.index');
            }
        }
        session()->flash('alert.config', [
            'icon' => 'success',
            'title' => 'Berhasil',
            'text' => 'Kategori Berhasil Dihapus'
        ]);
        return redirect()->route('admin.kategoriaplikasi.index');
    }
}
