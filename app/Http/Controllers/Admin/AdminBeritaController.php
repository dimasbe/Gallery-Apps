<?php

namespace App\Http\Controllers\Admin;

use App\Contracts\Interfaces\BeritaInterface;
use App\Contracts\Interfaces\KategoriBeritaInterface;
use App\Contracts\Interfaces\FotoBeritaInterface;
use App\Http\Controllers\Controller; // ✅ INI WAJIB DITAMBAHKAN
use App\Http\Requests\StoreBeritaRequest;
use App\Http\Requests\UpdateBeritaRequest;
use App\Models\Berita;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use RealRashid\SweetAlert\Facades\Alert;

class AdminBeritaController extends Controller
{
    private BeritaInterface $berita;
    private KategoriBeritaInterface $kategoriBerita;
    private FotoBeritaInterface $fotoBerita;

    public function __construct(BeritaInterface $berita, FotoBeritaInterface $fotoBerita, KategoriBeritaInterface $kategoriBerita)
    {
        $this->berita = $berita;
        $this->kategoriBerita = $kategoriBerita;
        $this->fotoBerita = $fotoBerita;
    }

    public function index(): View
    {
        $berita = $this->berita->get();
        $kategoriBerita = $this->kategoriBerita->get();
        $fotoBerita = $this->fotoBerita->get();

        return view('berita.index', compact('berita', 'kategoriBerita', 'fotoBerita'));
    }

    public function create(): View
    {
        $kategoriBerita = $this->kategoriBerita->get();
        $fotoBerita = $this->fotoBerita->get();

        return view('berita.create', compact('kategoriBerita', 'fotoBerita'));
    }

    public function store(StoreBeritaRequest $request): RedirectResponse
    {
        try {
            $this->berita->store($request->validated());
            Alert::success('Berhasil', 'Berita berhasil ditambahkan');
            return redirect()->route('berita.index');
        } catch (\Illuminate\Validation\ValidationException $e) {
            Alert::error('Gagal', 'Silakan periksa kembali form Anda');
            return back()->withErrors($e->validator)->withInput();
        }
    }

    public function show(Berita $berita): View
    {
        $detail = $this->berita->show($berita->id);
        $kategoriBerita = $this->kategoriBerita->get();
        $fotoBerita = $this->fotoBerita->get();

        return view('berita.show', compact('detail', 'kategoriBerita', 'fotoBerita'));
    }

    public function edit(Berita $berita): View
    {
        $detail = $this->berita->show($berita->id);
        $kategoriBerita = $this->kategoriBerita->get();
        $fotoBerita = $this->fotoBerita->get();

        return view('berita.edit', compact('detail', 'kategoriBerita', 'fotoBerita'));
    }

    public function update(UpdateBeritaRequest $request, Berita $berita): RedirectResponse
    {
        try {
            $this->berita->update($berita->id, $request->validated());
            Alert::success('Berhasil', 'Berita berhasil diperbarui');
            return redirect()->route('berita.index');
        } catch (\Illuminate\Validation\ValidationException $e) {
            Alert::error('Gagal', 'Silakan periksa kembali form Anda');
            return back()->withErrors($e->validator)->withInput();
        }
    }

    public function destroy(Berita $berita): RedirectResponse
    {
        try {
            $this->berita->delete($berita->id);
            Alert::success('Berhasil', 'Berita berhasil dihapus');
            return back();
        } catch (QueryException $e) {
            if ($e->errorInfo[1] == 1451) {
                Alert::error('Gagal', 'Berita tidak dapat dihapus karena masih terkait dengan data lain');
                return to_route('berita.index');
            }
        }

        Alert::success('Berhasil', 'Berita berhasil dihapus');
        return redirect()->route('berita.index');
    }

    public function search(Request $request): View
    {
        $keyword = $request->input('keyword');
        $berita = $this->berita->search($request);
        $kategoriBerita = $this->kategoriBerita->get();
        $fotoBerita = $this->fotoBerita->get();

        return view('berita.search', compact('berita', 'kategoriBerita', 'fotoBerita', 'keyword'));
    }

    public function detail(): View
    {
        $kategoriBerita = $this->kategoriBerita->get();
        $fotoBerita = $this->fotoBerita->get();

        return view('berita.detail', compact('kategoriBerita', 'fotoBerita'));
    }
}
