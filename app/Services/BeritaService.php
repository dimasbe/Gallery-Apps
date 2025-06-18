<?php

namespace App\Services;

use App\Contracts\Interfaces\BeritaInterface;
use App\Contracts\Interfaces\FotoBeritaInterface;
use App\Contracts\Interfaces\KategoriInterface;
use App\Models\Berita; // Diperlukan untuk metode-metode yang langsung berinteraksi dengan model
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request; // Import kelas Request

class BeritaService
{
    protected BeritaInterface $berita;
    protected FotoBeritaInterface $fotoBerita;
    protected KategoriInterface $kategori;

    public function __construct(
        BeritaInterface $berita,
        FotoBeritaInterface $fotoBerita,
        KategoriInterface $kategori
    ) {
        $this->berita = $berita;
        $this->fotoBerita = $fotoBerita;
        $this->kategori = $kategori;
    }

    public function getAllWithKategori($keyword = null)
{
    $query = Berita::with('kategori'); // asumsi relasi kategori

    if ($keyword) {
        $query->where('judul_berita', 'like', '%' . $keyword . '%');
    }

    return $query->orderBy('tanggal_dibuat', 'desc')->get(); // tambahkan ini
}

    public function getKategoriBerita()
    {
        return $this->kategori->filterBySubKategori('berita');
    }

    public function createBerita(array $data, $thumbnailFile = null)
    {
        $data['tanggal_dibuat'] = now();
        $data['tanggal_diedit'] = now();

        $berita = $this->berita->store($data);

        if ($thumbnailFile) {
            $fileName = $thumbnailFile->store('berita-thumbnails', 'public');

            $this->fotoBerita->store([
                'berita_id' => $berita->id,
                'nama_gambar' => $fileName,
                'tipe' => 'thumbnail',
            ]);
        }

        return $berita;
    }

    public function updateBerita($berita, array $data, $thumbnailFile = null)
    {
        $data['tanggal_diedit'] = now();

        $this->berita->update($berita->id, $data);

        if ($thumbnailFile) {
            $existingThumbnail = $berita->fotoBerita()->where('tipe', 'thumbnail')->first();

            if ($existingThumbnail) {
                Storage::disk('public')->delete($existingThumbnail->nama_gambar);
                $this->fotoBerita->delete($existingThumbnail->id);
            }

            $fileName = $thumbnailFile->store('berita-thumbnails', 'public');
            $this->fotoBerita->store([
                'berita_id' => $berita->id,
                'nama_gambar' => $fileName,
                'tipe' => 'thumbnail',
            ]);
        }
    }

    public function deleteBerita($berita)
    {
        foreach ($berita->fotoBerita as $foto) {
            Storage::disk('public')->delete($foto->nama_gambar);
            $this->fotoBerita->delete($foto->id);
        }

        $this->berita->delete($berita->id);
    }

    /**
     * Memperbaiki tipe parameter agar sesuai dengan yang diharapkan oleh BeritaInterface::search().
     * Asumsi BeritaInterface::search() mengharapkan objek Request.
     * @param  \Illuminate\Http\Request  $request Objek Request yang berisi keyword pencarian
     * @return mixed
     */
    public function searchBerita(Request $request) // Mengubah tipe parameter menjadi Request
    {
        // Meneruskan objek Request langsung ke metode search pada interface
        return $this->berita->search($request);
    }

    public function getAllPaginated($perPage = null, $kategoriId = null, $search = null)
{
    $query = Berita::with([
        'kategori',
        'fotoBerita' => function ($query) {
            $query->where('tipe', 'thumbnail');
        }
    ])->orderBy('tanggal_dibuat', 'desc');

    if ($kategoriId) {
        $query->where('kategori_id', $kategoriId);
    }

    if ($search) {
        $query->where(function ($q) use ($search) {
            $q->where('judul_berita', 'like', '%' . $search . '%')
              ->orWhere('isi_berita', 'like', '%' . $search . '%');
        });
    }

    if ($perPage) {
        return $query->paginate($perPage)->withQueryString(); // agar query URL tetap ada saat paging
    }

    return $query->get();
}

    
    public function findById($id)
    {
        return Berita::with(['kategori', 'fotoBerita'])->findOrFail($id);
    }

    public function getBeritaTerkait($kategoriId, $excludeBeritaId, $limit = 5)
    {
        return Berita::with(['kategori', 'fotoBerita' => function ($q) {
                $q->where('tipe', 'thumbnail');
            }])
            ->where('kategori_id', $kategoriId)        // berita dari kategori yang sama
            ->where('id', '!=', $excludeBeritaId)      // kecuali berita yang sedang dibuka
            ->orderBy('tanggal_dibuat', 'desc')
            ->limit($limit)
            ->get();
    }
}