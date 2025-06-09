<?php

namespace App\Services;

use App\Contracts\Interfaces\BeritaInterface;
use App\Contracts\Interfaces\FotoBeritaInterface;
use App\Contracts\Interfaces\KategoriInterface;
use App\Models\Berita;
use Illuminate\Support\Facades\Storage;

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

    public function getAllWithKategori()
    {
        return $this->berita->getAllWithKategori();
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

    public function searchBerita(string $keyword)
    {
        return $this->berita->search(['keyword' => $keyword]);
    }

    public function getAllPaginated($perPage = null, $kategoriId = null)
    {
        $query = Berita::with([
            'kategori',
            'fotoBerita' => function ($query) {
                $query->where('tipe', 'thumbnail');
            }
        ])->orderBy('tanggal_dibuat', 'desc');
    
        // Filter berdasarkan kategori jika ada
        if ($kategoriId) {
            $query->whereHas('kategori', function ($q) use ($kategoriId) {
                $q->where('kategori_id', $kategoriId);
            });
        }
    
        // Kembalikan hasil paginate jika perPage diisi
        if ($perPage) {
            return $query->paginate($perPage)->withQueryString(); // agar query ?kategori tetap ada saat pagination
        }
    
        // Kalau tidak, ambil semua
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
            ->where('kategori_id', $kategoriId)          // berita dari kategori yang sama
            ->where('id', '!=', $excludeBeritaId)       // kecuali berita yang sedang dibuka
            ->orderBy('tanggal_dibuat', 'desc')
            ->limit($limit)
            ->get();
    }

    public function getLatest($jumlah = 3)
{
    return Berita::latest()->take($jumlah)->get();
}



}
