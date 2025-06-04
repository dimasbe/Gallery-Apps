<?php

namespace App\Http\Controllers\Admin;

use App\Contracts\Interfaces\BeritaInterface;
use App\Contracts\Interfaces\KategoriInterface;
use App\Contracts\Interfaces\FotoBeritaInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBeritaRequest;
use App\Http\Requests\UpdateBeritaRequest;
use App\Models\Berita;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Carbon;

class AdminBeritaController extends Controller
{
    protected BeritaInterface $berita;
    protected KategoriInterface $kategori;
    protected FotoBeritaInterface $fotoBerita;

    public function __construct(
        BeritaInterface $berita,
        FotoBeritaInterface $fotoBerita,
        KategoriInterface $kategori
    ) {
        $this->berita = $berita;
        $this->fotoBerita = $fotoBerita;
        $this->kategori = $kategori;
    }

    public function index(): View
{
    $berita = Berita::with('kategori')->get(); // langsung query model
    return view('admin.berita.index', compact('berita'));
}


public function create(): View
{
    return view('admin.berita.create', [
        'kategori' => $this->kategori->filterBySubKategori('berita'),
    ]);
}

    public function store(StoreBeritaRequest $request): RedirectResponse
    {
        $validatedData = $request->validated();
    
        $thumbnailFile = $request->file('thumbnail');
    
        $beritaData = [
            'judul_berita' => $validatedData['judul_berita'],
            'penulis' => $validatedData['penulis'],
            'kategori_id' => $validatedData['kategori_id'],
            'isi_berita' => $validatedData['isi_berita'],
            'tanggal_dibuat' => now(),
            'tanggal_diedit' => now(),
        ];
    
        $berita = $this->berita->store($beritaData);
    
        if ($thumbnailFile) {
            $fileName = $thumbnailFile->store('berita-thumbnails', 'public');
    
            $this->fotoBerita->store([
                'berita_id' => $berita->id,
                'nama_gambar' => $fileName,
                'tipe' => 'thumbnail',
            ]);
        }
    
        return redirect()->route('admin.berita.index')->with('success', 'Berita berhasil ditambahkan.');
    }
    
    public function show(Berita $berita): View
    {
        return view('admin.berita.show', [
            'detail' => $this->berita->show($berita->id),
        ]);
    }

    public function edit(Berita $berita): View
    {
        return view('admin.berita.edit', [
            'detail' => $this->berita->show($berita->id),
            'kategori' => $this->kategori->get(),
        ]);
    }

    public function update(UpdateBeritaRequest $request, Berita $berita): RedirectResponse
    {
        $validatedData = $request->validated();

        try {
            $thumbnailFile = $request->file('thumbnail');

            $beritaData = [
                'judul_berita' => $validatedData['judul_berita'],
                'penulis' => $validatedData['penulis'],
                'kategori_id' => $validatedData['kategori_id'],
                'isi_berita' => $validatedData['isi_berita'],
                'tanggal_diedit' => Carbon::now(),
            ];

            $this->berita->update($berita->id, $beritaData);

            if ($thumbnailFile) {
                // Menggunakan relasi fotoBerita() (singular)
                $existingThumbnail = $berita->fotoBerita()->where('tipe', 'thumbnail')->first();
                if ($existingThumbnail) {
                    Storage::disk('public')->delete($existingThumbnail->nama_gambar);
                    $this->fotoBerita->delete($existingThumbnail->id);
                }

                $this->fotoBerita->store([
                    'berita_id' => $berita->id,
                    'nama_gambar' => $thumbnailFile,
                    'tipe' => 'thumbnail',
                ]);
            }

            session()->flash('success', 'Berita berhasil diperbarui.');
            return redirect()->route('admin.berita.index');
        } catch (\Exception $e) {
            \Log::error('Error updating berita: ' . $e->getMessage());
            session()->flash('error', 'Terjadi kesalahan saat memperbarui data: ' . $e->getMessage());
            return back()->withInput();
        }
    }

    public function destroy(Berita $berita): RedirectResponse
    {
        try {
            // Menggunakan relasi fotoBerita (singular)
            foreach ($berita->fotoBerita as $foto) {
                Storage::disk('public')->delete($foto->nama_gambar);
                $this->fotoBerita->delete($foto->id);
            }

            $this->berita->delete($berita->id);

            session()->flash('success', 'Berita berhasil dihapus.');
        } catch (QueryException $e) {
            if ($e->errorInfo[1] == 1451) {
                session()->flash('error', 'Berita tidak dapat dihapus karena masih terkait dengan data lain.');
            } else {
                session()->flash('error', 'Terjadi kesalahan saat menghapus: ' . $e->getMessage());
            }
        } catch (\Exception $e) {
            \Log::error('Error deleting berita: ' . $e->getMessage());
            session()->flash('error', 'Terjadi kesalahan umum saat menghapus: ' . $e->getMessage());
        }

        return redirect()->route('admin.berita.index');
    }

    public function search(Request $request): View
    {
        $keyword = $request->input('keyword');

        // Asumsi search() di interface menerima array request
        return view('admin.berita.index', [
            'berita' => $this->berita->search($request->all()), // Mengirim $berita (tunggal)
            'keyword' => $keyword,
        ]);
    }
}