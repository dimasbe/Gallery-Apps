<?php

namespace App\Contracts\Repositories;

use App\Contracts\Interfaces\BeritaInterface;
use App\Contracts\Interfaces\Eloquent\SearchInterface;
use App\Models\Berita;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class BeritaRepository extends BaseRepository implements BeritaInterface
{
    public function __construct(Berita $berita)
    {
        $this->model = $berita;
    }

    /**
     * Mengambil semua berita dengan relasi (kategori, fotoBerita).
     * Relasi 'penulis' dihapus karena menyebabkan error.
     *
     * @return Collection
     */
    public function getAllWithKategori(): Collection
    {
        return $this->model->with([
                'kategori',
                // 'penulis', // <<< DIHAPUS: Karena menyebabkan "Call to undefined relationship [penulis]"
                'fotoBerita' => function ($query) {
                    $query->where('tipe', 'thumbnail');
                }
            ])
            ->orderBy('tanggal_dibuat', 'desc')
            ->get();
    }

    /**
     * Mengambil satu berita berdasarkan ID.
     * Relasi 'penulis' dihapus.
     *
     * @param mixed $id
     * @return Berita
     */
    public function findById(mixed $id): Berita
    {
        return $this->model->with([
                'kategori',
                // 'penulis', // <<< DIHAPUS
                'fotoBerita'
            ])
            ->findOrFail($id);
    }

    /**
     * Simpan berita baru.
     * (Metode ini tidak memuat relasi, jadi tidak ada perubahan di sini)
     */
    public function store(array $data): Berita
    {
        return $this->model->create($data);
    }

    /**
     * Perbarui berita berdasarkan ID.
     * (Metode ini tidak memuat relasi, jadi tidak ada perubahan di sini)
     */
    public function update(mixed $id, array $data): bool
    {
        $berita = $this->model->findOrFail($id);
        return $berita->update($data);
    }

    /**
     * Hapus berita berdasarkan ID.
     * (Metode ini tidak memuat relasi, jadi tidak ada perubahan di sini)
     */
    public function delete(mixed $id): bool
    {
        $berita = $this->model->findOrFail($id);
        return $berita->delete();
    }

    /**
     * Mencari berita berdasarkan keyword di judul atau kategori.
     * Relasi 'penulis' dihapus.
     *
     * @param  \Illuminate\Http\Request  $request Objek request HTTP yang berisi parameter pencarian
     * @return Collection
     */
    public function search(Request $request): Collection
    {
        $keyword = $request->input('keyword');
        $kategoriId = $request->input('kategori_id');

        $query = $this->model->with([
                'kategori',
                // 'penulis', // <<< DIHAPUS
                'fotoBerita' => function ($q) {
                    $q->where('tipe', 'thumbnail');
                }
            ]);

        if ($keyword) {
            $query->where(function ($q) use ($keyword) {
                $q->where('judul_berita', 'like', "%{$keyword}%")
                    ->orWhere('isi_berita', 'like', "%{$keyword}%")
                    ->orWhereHas('kategori', function ($subQ) use ($keyword) {
                        $subQ->where('nama_kategori', 'like', "%{$keyword}%");
                    });
            });
        }

        if ($kategoriId) {
            $query->whereHas('kategori', function ($q) use ($kategoriId) {
                $q->where('id', $kategoriId);
            });
        }

        return $query->orderBy('tanggal_dibuat', 'desc')
            ->get();
    }

    /**
     * Mendapatkan sejumlah berita terbaru.
     * Relasi 'penulis' dihapus.
     *
     * @param int $limit Batasan jumlah berita yang diambil.
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getLatest(int $limit = 3): Collection
    {
        return $this->model->with([
                'kategori',
                // 'penulis', // <<< DIHAPUS
                'fotoBerita' => function ($query) {
                    $query->where('tipe', 'thumbnail');
                }
            ])
            ->orderBy('tanggal_dibuat', 'desc')
            ->take($limit)
            ->get();
    }

    /**
     * Mengambil semua berita dengan paginasi.
     * Relasi 'penulis' dihapus.
     *
     * @param int|null $perPage Jumlah item per halaman.
     * @param int|null $kategoriId ID kategori untuk filter.
     * @return LengthAwarePaginator
     */
    public function getAllPaginated(?int $perPage = 10, ?int $kategoriId = null): LengthAwarePaginator
    {
        $query = $this->model->with([
            'kategori',
            // 'penulis', // <<< DIHAPUS
            'fotoBerita' => function ($query) {
                $query->where('tipe', 'thumbnail');
            }
        ])->orderBy('tanggal_dibuat', 'desc');

        if ($kategoriId) {
            $query->whereHas('kategori', function ($q) use ($kategoriId) {
                $q->where('id', $kategoriId);
            });
        }

        return $query->paginate($perPage ?? 10);
    }
}
