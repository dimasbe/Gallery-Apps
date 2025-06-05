<?php

namespace App\Services;

use App\Contracts\Interfaces\BeritaInterface;
use App\Contracts\Interfaces\FotoBeritaInterface;
use App\Contracts\Interfaces\KategoriInterface;
use App\Models\Berita; // Mungkin masih diperlukan jika Anda melakukan 'Berita::query()' di service.
                     // Namun, lebih baik semua query langsung dari repository.
use Illuminate\Support\Facades\Storage;
use Illuminate\Pagination\LengthAwarePaginator; // Pastikan ini diimpor
use Illuminate\Database\Eloquent\Collection; // Pastikan ini diimpor

class BeritaService
{
    protected BeritaInterface $berita; // Ini adalah instance BeritaRepository
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

    /**
     * Membuat berita baru.
     * @param array $data Data berita (judul_berita, penulis, isi_berita, kategori_id, keterangan_thumbnail)
     * @param mixed $thumbnailFile File thumbnail yang diupload
     * @return \App\Models\Berita
     */
    public function createBerita(array $data, $thumbnailFile = null)
    {
        $data['tanggal_dibuat'] = now();
        $data['tanggal_diedit'] = now();

        $berita = $this->berita->store($data);

        if ($thumbnailFile) {
            // Simpan file thumbnail ke storage 'public/berita/thumbnails'
            $path = $thumbnailFile->store('berita/thumbnails', 'public');

            $this->fotoBerita->store([
                'berita_id' => $berita->id,
                'nama_gambar' => str_replace('public/', '', $path), // Simpan path tanpa 'public/'
                'keterangan_gambar' => $data['keterangan_thumbnail'] ?? null, // Ambil dari data
                'tipe' => 'thumbnail',
            ]);
        }

        return $berita;
    }

    /**
     * Memperbarui berita yang sudah ada.
     * @param \App\Models\Berita $berita Instance berita yang akan diupdate
     * @param array $data Data berita yang akan diupdate
     * @param mixed $thumbnailFile File thumbnail baru (opsional)
     * @return void
     */
    public function updateBerita(Berita $berita, array $data, $thumbnailFile = null)
    {
        $data['tanggal_diedit'] = now();

        // Update data berita utama melalui repository
        $this->berita->update($berita->id, $data);

        if ($thumbnailFile) {
            // Hapus thumbnail lama jika ada
            $oldThumbnail = $berita->fotoBeritas()->where('tipe', 'thumbnail')->first();
            if ($oldThumbnail) {
                Storage::disk('public')->delete($oldThumbnail->nama_gambar);
                $this->fotoBerita->delete($oldThumbnail->id);
            }

            // Simpan thumbnail baru
            $path = $thumbnailFile->store('berita/thumbnails', 'public');
            $this->fotoBerita->store([
                'berita_id' => $berita->id,
                'nama_gambar' => str_replace('public/', '', $path),
                'keterangan_gambar' => $data['keterangan_thumbnail'] ?? null,
                'tipe' => 'thumbnail',
            ]);
        } else if (isset($data['keterangan_thumbnail'])) { // Update keterangan thumbnail tanpa gambar baru
            $thumbnail = $berita->fotoBeritas()->where('tipe', 'thumbnail')->first();
            if ($thumbnail) {
                $thumbnail->update(['keterangan_gambar' => $data['keterangan_thumbnail']]);
            }
        }
    }

    /**
     * Menghapus berita dan semua foto terkaitnya.
     * @param \App\Models\Berita $berita Instance berita yang akan dihapus
     * @return void
     */
    public function deleteBerita(Berita $berita)
    {
        // Hapus semua foto terkait dari storage
        foreach ($berita->fotoBeritas as $foto) {
            Storage::disk('public')->delete($foto->nama_gambar);
            $this->fotoBerita->delete($foto->id); // Hapus record dari database
        }

        // Hapus berita itu sendiri melalui repository
        $this->berita->delete($berita->id);
    }

    /**
     * Melakukan pencarian berita.
     * @param string $keyword Kata kunci pencarian
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function searchBerita(string $keyword)
    {
        // Karena repository search() sekarang menerima Request, kita perlu membuat dummy Request
        // ATAU ubah searchBerita di service ini untuk menerima Request juga.
        // Untuk saat ini, kita buat dummy Request agar kompatibel.
        $request = new \Illuminate\Http\Request(['keyword' => $keyword]);
        return $this->berita->search($request);
    }

    /**
     * Mengambil semua berita dengan paginasi, dengan opsi kategori.
     * Metode ini memanggil getAllPaginated dari repository.
     *
     * @param int|null $perPage Jumlah item per halaman.
     * @param int|null $kategoriId ID kategori untuk filter.
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function getAllPaginated(?int $perPage = null, ?int $kategoriId = null): LengthAwarePaginator
    {
        // Langsung panggil metode dari repository
        return $this->berita->getAllPaginated($perPage, $kategoriId);
    }

    /**
     * Mendapatkan sejumlah berita terbaru.
     * Metode ini memanggil getLatest dari repository.
     *
     * @param int $limit Batasan jumlah berita yang diambil.
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getLatest(int $limit = 3): Collection
    {
        return $this->berita->getLatest($limit);
    }

    /**
     * Mencari berita berdasarkan ID.
     * Metode ini memanggil findById dari repository.
     *
     * @param int $id ID berita.
     * @return \App\Models\Berita|null
     */
    public function findById($id)
    {
        return $this->berita->findById($id);
    }
}
