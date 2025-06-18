<?php

namespace App\Contracts\Repositories;

use App\Contracts\Interfaces\BeritaInterface;
use App\Models\Berita;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class BeritaRepository extends BaseRepository implements BeritaInterface
{
    public function __construct(Berita $berita)
    {
        $this->model = $berita;
    }

    /**
     * Mengambil semua berita dengan relasi (kategori, fotoBerita) dengan paginasi dan pencarian.
     *
     * @param int $perPage
     * @param string|null $keyword
     * @return LengthAwarePaginator
     */
    public function getAllWithKategori(int $perPage = 10, string $keyword = null): LengthAwarePaginator
    {
        $query = $this->model->with([
            'kategori',
            'fotoBerita' => function ($query) {
                $query->where('tipe', 'thumbnail');
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

        return $query->orderBy('tanggal_dibuat', 'desc')->paginate($perPage);
    }

    /**
     * Mengambil satu berita berdasarkan ID.
     *
     * @param mixed $id
     * @return Berita
     */
    public function findById(mixed $id): Berita
    {
        return $this->model->with([
                'kategori',
                'fotoBerita'
            ])
            ->findOrFail($id);
    }

    /**
     * Simpan berita baru.
     *
     * @param array $data
     * @return Berita
     */
    public function store(array $data): Berita
    {
        return $this->model->create($data);
    }

    /**
     * Perbarui berita berdasarkan ID.
     *
     * @param mixed $id
     * @param array $data
     * @return bool
     */
    public function update(mixed $id, array $data): bool
    {
        $berita = $this->model->findOrFail($id);
        return $berita->update($data);
    }

    /**
     * Hapus berita berdasarkan ID.
     *
     * @param mixed $id
     * @return bool
     */
    public function delete(mixed $id): bool
    {
        $berita = $this->model->findOrFail($id);
        return $berita->delete();
    }

    /**
     * Mencari berita berdasarkan keyword di judul atau kategori.
     * Catatan: Metode ini di repository akan dipanggil oleh Service, bukan Request langsung.
     * Ubah tanda tangannya agar sesuai dengan kebutuhan service Anda.
     *
     * @param string|null $keyword
     * @param int|null $kategoriId
     * @return Collection
     */

     /*public function search(?string $keyword = null, ?int $kategoriId = null): Collection 
    {
        $query = $this->model->with([
            'kategori',
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

        return $query->orderBy('tanggal_dibuat', 'desc')->get();
    }*/

    /**
     * Mendapatkan sejumlah berita terbaru.
     *
     * @param int $limit
     * @return Collection
     */
    public function getLatest(int $limit = 3): Collection
    {
        return $this->model->with([
                'kategori',
                'fotoBerita' => function ($query) {
                    $query->where('tipe', 'thumbnail');
                }
            ])
            ->orderBy('tanggal_dibuat', 'desc')
            ->take($limit)
            ->get();
    }

    // Metode paginate dan getAllPaginated kemungkinan bisa dihapus jika getAllWithKategori sudah memadai.
    public function paginate(int $pagination = 10): LengthAwarePaginator
    {
        return $this->model->with([
                'kategori',
                'fotoBerita' => function ($query) {
                    $query->where('tipe', 'thumbnail');
                }
            ])
            ->orderBy('tanggal_dibuat', 'desc')
            ->paginate($pagination);
    }

    public function getAllPaginated(?int $perPage = 10, ?int $kategoriId = null): LengthAwarePaginator
    {
        $query = $this->model->with([
            'kategori',
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
