<?php

namespace App\Contracts\Repositories;

use App\Contracts\Interfaces\BeritaInterface;
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
     *
     * @return Collection
     */
    public function getAllWithKategori(): Collection
    {
        return $this->model->with([
                'kategori',
                'fotoBerita' => function ($query) {
                    $query->where('tipe', 'thumbnail');
                }
            ])
            ->orderBy('tanggal_dibuat', 'desc')
            ->get();
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
     *
     * @param Request $request
     * @return Collection
     */
    public function search(Request $request): Collection
    {
        $keyword = $request->input('keyword');
        $kategoriId = $request->input('kategori_id');

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
    }

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

    /**
     * Paginasi umum tanpa filter.
     *
     * @param int $pagination
     * @return LengthAwarePaginator
     */
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

    /**
     * Paginasi dengan filter kategori.
     *
     * @param int|null $perPage
     * @param int|null $kategoriId
     * @return LengthAwarePaginator
     */
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
