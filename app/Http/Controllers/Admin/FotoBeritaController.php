<?php

namespace App\Http\Controllers\Admin;

use App\Contracts\Interfaces\FotoBeritaInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFotoBeritaRequest;
use App\Http\Requests\UpdateFotoBeritaRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use RealRashid\SweetAlert\Facades\Alert;

class AdminFotoBeritaController extends Controller
{
    protected FotoBeritaInterface $fotoBerita;

    public function __construct(FotoBeritaInterface $fotoBerita)
    {
        $this->fotoBerita = $fotoBerita;
    }

    public function index(): View
    {
        $fotoBerita = $this->fotoBerita->get();
        return view('fotoberita.index', compact('fotoBerita'));
    }

    public function create(): View
    {
        return view('fotoberita.create');
    }

    public function store(StoreFotoBeritaRequest $request): RedirectResponse
    {
        try {
            // Misal ada upload file, kamu bisa handle di repository atau di controller
            $data = $request->validated();

            // Contoh handle file upload (optional)
            if ($request->hasFile('foto')) {
                $file = $request->file('foto');
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('uploads/foto_berita'), $filename);
                $data['foto'] = $filename;
            }

            $this->fotoBerita->store($data);

            Alert::success('Berhasil', 'Foto berita berhasil ditambahkan');
            return redirect()->route('fotoberita.index');
        } catch (\Exception $e) {
            Alert::error('Gagal', 'Terjadi kesalahan saat menyimpan foto');
            return back()->withInput();
        }
    }

    public function edit(int $id): View
    {
        $foto = $this->fotoBerita->show($id);
        return view('fotoberita.edit', compact('foto'));
    }

    public function update(UpdateFotoBeritaRequest $request, int $id): RedirectResponse
    {
        try {
            $data = $request->validated();

            if ($request->hasFile('foto')) {
                $file = $request->file('foto');
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('uploads/foto_berita'), $filename);
                $data['foto'] = $filename;
            }

            $this->fotoBerita->update($id, $data);

            Alert::success('Berhasil', 'Foto berita berhasil diperbarui');
            return redirect()->route('fotoberita.index');
        } catch (\Exception $e) {
            Alert::error('Gagal', 'Terjadi kesalahan saat memperbarui foto');
            return back()->withInput();
        }
    }

    public function destroy(int $id): RedirectResponse
    {
        try {
            $this->fotoBerita->delete($id);
            Alert::success('Berhasil', 'Foto berita berhasil dihapus');
        } catch (\Exception $e) {
            Alert::error('Gagal', 'Terjadi kesalahan saat menghapus foto');
        }

        return redirect()->route('fotoberita.index');
    }
}
