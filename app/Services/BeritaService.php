<?php

namespace App\Services;

use App\Contracts\Interfaces\BeritaInterface;
use App\Contracts\Interfaces\FotoBeritaInterface;
use App\Contracts\Interfaces\KategoriInterface;
use App\Models\Berita; // Diperlukan untuk metode-metode yang langsung berinteraksi dengan model
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile; // Import UploadedFile untuk type hinting
use Illuminate\Pagination\LengthAwarePaginator; // Import LengthAwarePaginator

class BeritaService
{
    protected BeritaInterface $beritaRepository; // Ganti nama variabel untuk kejelasan
    protected FotoBeritaInterface $fotoBeritaRepository; // Ganti nama variabel untuk kejelasan
    protected KategoriInterface $kategoriRepository; // Ganti nama variabel untuk kejelasan

    public function __construct(
        BeritaInterface $berita,
        FotoBeritaInterface $fotoBerita,
        KategoriInterface $kategori
    ) {
        $this->beritaRepository = $berita;
        $this->fotoBeritaRepository = $fotoBerita;
        $this->kategoriRepository = $kategori;
    }

    /**
     * Mengambil semua berita dengan kategori terkait, paginasi, dan opsi pencarian.
     *
     * @param int $perPage
     * @param string|null $keyword
     * @return LengthAwarePaginator
     */
    public function getAllWithKategori(int $perPage = 10, string $keyword = null): LengthAwarePaginator
    {
        // Panggil metode getAllWithKategori dari repository yang sudah menangani paginasi dan keyword
        return $this->beritaRepository->getAllWithKategori($perPage, $keyword);
    }

    public function getKategoriBerita()
    {
        return $this->kategoriRepository->filterBySubKategori('berita');
    }

    /**
     * Membuat berita baru.
     *
     * @param array $data
     * @param UploadedFile|null $thumbnailFile
     * @return Berita
     */
    public function createBerita(array $data, ?UploadedFile $thumbnailFile = null): Berita
    {
        $data['tanggal_dibuat'] = now();
        $data['tanggal_diedit'] = now();

        $berita = $this->beritaRepository->store($data);

        if ($thumbnailFile) {
            $fileName = $thumbnailFile->store('berita-thumbnails', 'public');

            $this->fotoBeritaRepository->store([
                'berita_id' => $berita->id,
                'nama_gambar' => $fileName,
                'tipe' => 'thumbnail',
                // Anda mungkin perlu menambahkan kolom url jika model FotoBerita memilikinya
                'url' => Storage::url($fileName), // Tambahkan ini jika dibutuhkan
                'ukuran_file' => $thumbnailFile->getSize(), // Tambahkan ini
                'mime_type' => $thumbnailFile->getMimeType(), // Tambahkan ini
            ]);
        }

        // Asumsi ada relasi many-to-many atau kategori_id langsung
        if (isset($data['kategori_id'])) {
            // Jika relasinya many-to-many:
            // $berita->kategori()->sync($data['kategori_id']);
            // Jika relasinya one-to-many (hanya 1 kategori_id):
            // $berita->update(['kategori_id' => $data['kategori_id']]);
            // Anda harus sesuaikan ini dengan model Berita Anda
        }

        return $berita;
    }

    /**
     * Memperbarui berita yang sudah ada.
     *
     * @param Berita $berita
     * @param array $data
     * @param UploadedFile|null $thumbnailFile
     * @return void
     */
    public function updateBerita(Berita $berita, array $data, ?UploadedFile $thumbnailFile = null): void
    {
        $data['tanggal_diedit'] = now();

        $this->beritaRepository->update($berita->id, $data);

        if ($thumbnailFile) {
            $existingThumbnail = $berita->fotoBerita()->where('tipe', 'thumbnail')->first();

            if ($existingThumbnail) {
                Storage::disk('public')->delete($existingThumbnail->nama_gambar);
                $this->fotoBeritaRepository->delete($existingThumbnail->id);
            }

            $fileName = $thumbnailFile->store('berita-thumbnails', 'public');
            $this->fotoBeritaRepository->store([
                'berita_id' => $berita->id,
                'nama_gambar' => $fileName,
                'tipe' => 'thumbnail',
                'url' => Storage::url($fileName), // Tambahkan ini jika dibutuhkan
                'ukuran_file' => $thumbnailFile->getSize(), // Tambahkan ini
                'mime_type' => $thumbnailFile->getMimeType(), // Tambahkan ini
            ]);
        }

        // Asumsi ada relasi many-to-many atau kategori_id langsung
        if (isset($data['kategori_id'])) {
            // Jika relasinya many-to-many:
            // $berita->kategori()->sync($data['kategori_id']);
            // Jika relasinya one-to-many (hanya 1 kategori_id):
            // $berita->update(['kategori_id' => $data['kategori_id']]);
            // Anda harus sesuaikan ini dengan model Berita Anda
        }
    }

    /**
     * Menghapus berita.
     *
     * @param Berita $berita
     * @return void
     */
    public function deleteBerita(Berita $berita): void
    {
        foreach ($berita->fotoBerita as $foto) {
            Storage::disk('public')->delete($foto->nama_gambar);
            $this->fotoBeritaRepository->delete($foto->id);
        }

        // Jika Anda memiliki relasi many-to-many dengan kategori, detach terlebih dahulu
        // $berita->kategori()->detach();

        $this->beritaRepository->delete($berita->id);
    }

    /**
     * Mendapatkan detail berita berdasarkan ID.
     *
     * @param int $id
     * @return Berita
     */
    public function findById(int $id): Berita
    {
        return $this->beritaRepository->findById($id);
    }

    public function getBeritaTerkait(int $kategoriId, int $excludeBeritaId, int $limit = 5): \Illuminate\Database\Eloquent\Collection
    {
        return Berita::with(['kategori', 'fotoBerita' => function ($q) {
                $q->where('tipe', 'thumbnail');
            }])
            ->where('kategori_id', $kategoriId)
            ->where('id', '!=', $excludeBeritaId)
            ->orderBy('tanggal_dibuat', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Mengambil semua berita dengan paginasi, filter kategori, dan pencarian.
     *
     * @param int|null $perPage
     * @param int|null $kategoriId
     * @param string|null $search
     * @return LengthAwarePaginator
     */
    public function getAllPaginated(?int $perPage = 10, ?int $kategoriId = null, ?string $search = null): LengthAwarePaginator
    {
        // Panggil metode dari repository
        // Asumsi BeritaRepository memiliki metode ini dan bisa menerima search
        return $this->beritaRepository->getAllPaginated($perPage, $kategoriId, $search);
    }
}
