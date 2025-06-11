<?php

namespace App\Contracts\Repositories;

use App\Contracts\Interfaces\KategoriInterface;
use App\Models\Kategori;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class KategoriRepository extends BaseRepository implements KategoriInterface
{

    protected Model $model;

    public function __construct(Kategori $kategori)
    {
        $this->model = $kategori;
    }

    /**
     * Get all kategori data ordered by tanggal_dibuat descending.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function get(): mixed
    {
        return $this->model->orderBy('tanggal_dibuat', 'desc')->get();
    }

    /**
     * Filter kategori berdasarkan sub_kategori.
     *
     * @param string $subKategori
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function filterBySubKategori(string $subKategori): mixed
    {
        return $this->model
            ->where('sub_kategori', $subKategori)
            ->orderBy('tanggal_dibuat', 'desc')
            ->get();
    }

    /**
     * Simpan data kategori baru, termasuk upload gambar jika ada.
     *
     * @param array $data
     * @return Kategori
     */
    public function store(array $data): mixed
    {
        if (isset($data['gambar'])) {
            $data['gambar'] = $this->uploadImage($data['gambar']);
        }
        return $this->model->create($data);
    }

    /**
     * Ambil data kategori berdasarkan id.
     *
     * @param mixed $id
     * @return Kategori
     */
    public function show(mixed $id): mixed
    {
        return $this->model->findOrFail($id);
    }

    /**
     * Ambil data kategori berdasarkan nama dengan aplikasi terkait.
     *
     * @param string $namaKategori
     * @return Kategori
     */
    public function getByNameWithAplikasi(string $namaKategori): mixed
    {
        // Asumsi ada relasi 'aplikasi' di model Kategori
        return $this->model->where('nama_kategori', $namaKategori)->with('aplikasi')->firstOrFail();
    }


    /**
     * Update data kategori, termasuk mengelola gambar lama dan baru.
     *
     * @param mixed $id
     * @param array $data
     * @return bool
     */
    public function update(mixed $id, array $data): mixed
    {
        $kategori = $this->show($id);

        if (isset($data['gambar'])) {
            $this->deleteImage($kategori->gambar);
            $data['gambar'] = $this->uploadImage($data['gambar']);
        } elseif (!empty($data['remove_gambar']) && $data['remove_gambar'] === 'true') {
            $this->deleteImage($kategori->gambar);
            $data['gambar'] = null;
        } else {
            unset($data['gambar']);
        }

        return $kategori->update($data);
    }

    /**
     * Hapus data kategori dan gambar terkait.
     *
     * @param mixed $id
     * @return bool|null
     */
    public function delete(mixed $id): mixed
    {
        $kategori = $this->show($id);
        $this->deleteImage($kategori->gambar);
        return $kategori->delete();
    }

    /**
     * Upload gambar ke storage dan kembalikan path publik.
     *
     * @param \Illuminate\Http\UploadedFile $file
     * @return string
     */
    protected function uploadImage($file): string
    {
        $path = $file->store('public/kategori_gambar');
        return str_replace('public/', 'storage/', $path);
    }

    /**
     * Hapus gambar dari storage.
     *
     * @param string|null $path
     * @return void
     */
    protected function deleteImage(?string $path): void
    {
        if ($path) {
            Storage::delete(str_replace('storage/', 'public/', $path));
        }
    }

    public function getAplikasiGroupedByKategori(int $month, int $year): Collection
    {
        $startDate = Carbon::create($year, $month, 1)->startOfMonth();
        $endDate = Carbon::create($year, $month, 1)->endOfMonth()->endOfDay(); 

        // Gabungkan tabel 'kategoris' dengan 'aplikasi'
        // Hitung aplikasi yang dibuat dalam rentang bulan/tahun tertentu
        return $this->model->select('kategori.nama_kategori', \DB::raw('COUNT(aplikasi.id_aplikasi) as aplikasi_count'))
                           ->leftJoin('aplikasi', 'kategori.id_kategori', '=', 'aplikasi.id_kategori') 
                           ->whereBetween('aplikasi.created_at', [$startDate, $endDate])
                           ->groupBy('kategori.nama_kategori')
                           ->orderBy('kategori.nama_kategori')
                           ->get();
    }
}