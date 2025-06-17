<?php

namespace App\Contracts\Repositories;

use App\Contracts\Interfaces\AplikasiInterface;
use App\Models\Aplikasi;
use App\Enums\StatusTypeEnum;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;


class AplikasiRepository extends BaseRepository implements AplikasiInterface
{
    protected Model $model;

    public function __construct(Aplikasi $aplikasi)
    {
        $this->model = $aplikasi;
    }

    /**
     * Get all applications with their categories, photos, and users.
     *
     * @return mixed
     */
    public function get(): mixed
    {
        return $this->model->query()->with('kategori', 'fotoAplikasi', 'users')->orderBy('id','DESC')->get();
    }

    public function getCount(): int{
        return $this->model->count();
    }

    /**
     * Retrieve a specific application by ID with related data.
     *
     * @param mixed $id
     * @return mixed
     */
    public function show(mixed $id): mixed
    {
        return $this->model->query()->with('kategori', 'fotoAplikasi', 'users')->findOrFail($id);
    }

    /**
     * Store a new application.
     *
     * @param array $data
     * @return mixed
     */
    public function store(array $data): mixed
    {
        return $this->model->create($data);
    }

    /**
     * Update an existing application by ID.
     *
     * @param mixed $id
     * @param array $data
     * @return mixed
     */
    public function update(mixed $id, array $data): mixed
    {
        $aplikasi = $this->model->query()->findOrFail($id);
        $aplikasi->update($data);
        return $aplikasi;
    }

    /**
     * Delete an application by ID.
     *
     * @param mixed $id
     * @return mixed
     */
    public function delete(mixed $id): mixed
    {
        $aplikasi = $this->model->query()->findOrFail($id);
        return $aplikasi->delete();
    }

    /**
     * Find an application by its primary key.
     *
     * @param mixed $id
     * @return mixed
     */
    public function find(mixed $id): mixed
    {
        return $this->model->query()->find($id);
    }

    /**
     * Search applications based on a keyword in application name, owner name, or category name.
     *
     * @param Request $request
     * @return mixed
     */
    public function search(Request $request): mixed
    {
        $keyword = $request->input('q');

        return $this->model->query()
            ->with('kategori', 'fotoAplikasi', 'users')
            ->where('nama_aplikasi', 'like', "%{$keyword}%")
            ->orWhere('nama_pemilik', 'like', "%{$keyword}%")
            ->orWhereHas('kategori', function ($query) use ($keyword) {
                $query->where('nama_kategori', 'like', "%{$keyword}%");
            })
            ->orderBy('id', 'DESC')
            ->get();
    }

    /**
     * Get applications submitted by a specific user.
     *
     * @param int|string $userId
     * @return mixed
     */
    public function getByUserId(int|string $userId): mixed
    {
        return $this->model->query()
            ->with('kategori', 'fotoAplikasi', 'users')
            ->where('id_user', $userId)
            ->orderBy('id', 'DESC')
            ->get();
    }

    /**
     * Get a number of the most popular applications based on visit count.
     *
     * @param int $limit
     * @return \Illuminate\Support\Collection
     */
    public function getPopularApps(int $limit): Collection
    {
        return $this->model->orderBy('jumlah_kunjungan', 'desc')
                           ->take($limit)
                           ->get();
    }

    /**
     * Apply common filters and eager loads for Aplikasi queries specific to history/admin views.
     *
     * @param Request $request
     * @param bool $isArchivedQuery If true, filters for archived items. If false, filters for non-archived verified items.
     * @return Builder
     */
    public function applyFilters(Request $request, bool $isArchivedQuery = false): Builder
    {
        $query = $this->model->query()->with(['users', 'kategori']);

        if ($isArchivedQuery) {
            $query->where('arsip', 1); // Only archived applications
        } else {
            $query->whereNotNull('tanggal_verifikasi') // Only show applications that have been verified
                  ->where('arsip', 0); // Only show non-archived items for regular history
        }

        // search filter
        if ($request->has('keyword') && $request->keyword != '') {
            $keyword = $request->keyword;
            $query->where(function($q) use ($keyword) {
                $q->where('nama_aplikasi', 'like', '%' . $keyword . '%')
                  ->orWhere('nama_pemilik', 'like', '%' . $keyword . '%')
                  ->orWhereHas('kategori', function ($q) use ($keyword) {
                      $q->where('nama_kategori', 'like', '%' . $keyword . '%');
                  });
            });
        }

        // status filter (only applicable for non-archived history)
        if (!$isArchivedQuery && $request->has('status') && $request->status !== 'semua') {
            if (in_array($request->status, [StatusTypeEnum::DITERIMA->value, StatusTypeEnum::DITOLAK->value])) {
                $query->where('status_verifikasi', $request->status);
            }
        }

        return $query;
    }

    /**
     * Get paginated verified applications with filters, for history views.
     *
     * @param Request $request
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getVerifiedPaginated(Request $request, int $perPage = 10): LengthAwarePaginator
    {
        $paginatedResults = $this->applyFilters($request, false)
                                ->orderBy('tanggal_verifikasi', 'desc')
                                ->paginate($perPage);

        // dd(
        //     '--- DEBUGGING PAGINATOR ---',
        //     'Total Data Ditemukan: ' . $paginatedResults->total(),
        //     'Jumlah Item Per Halaman: ' . $paginatedResults->perPage(),
        //     'Halaman Saat Ini: ' . $paginatedResults->currentPage(),
        //     'Total Halaman: ' . $paginatedResults->lastPage(),
        //     'Apakah ada halaman berikutnya?: ' . $paginatedResults->hasMorePages(),
        //     // SOLUSI: Konversi ke Collection sebelum memanggil pluck()
        //     'Item di Halaman Ini (sample IDs): ' . collect($paginatedResults->items())->pluck('id')->implode(', '),
        //     // Anda juga bisa melihat seluruh koleksi item jika perlu
        //     // 'Semua Item di Halaman Ini:', collect($paginatedResults->items())->toArray()
        // );
        return $paginatedResults;
    }

    /**
     * Find a verified application by ID with specific relations for detail view.
     *
     * @param mixed $id
     * @return mixed
     */
    public function findVerified($id): mixed
    {
        return $this->model->query()
            ->whereNotNull('tanggal_verifikasi')
            ->where('arsip', 0) // Ensure it's not an archived item for history detail
            ->with(['users', 'kategori', 'fotoAplikasi'])
            ->find($id);
    }

    /**
     * Mark an application as verified.
     *
     * @param mixed $id
     * @return mixed
     */
    public function verify($id): mixed
    {
        $aplikasi = $this->model->query()->find($id);
        if ($aplikasi) {
            $aplikasi->status_verifikasi = StatusTypeEnum::DITERIMA->value;
            $aplikasi->tanggal_verifikasi = now();
            $aplikasi->save();
        }
        return $aplikasi;
    }

    /**
     * Mark an application as rejected with a reason.
     *
     * @param mixed $id
     * @param string $reason
     * @return mixed
     */
    public function reject($id, string $reason): mixed
    {
        $aplikasi = $this->model->query()->find($id);
        if ($aplikasi) {
            $aplikasi->status_verifikasi = StatusTypeEnum::DITOLAK->value;
            $aplikasi->alasan_penolakan = $reason;
            $aplikasi->tanggal_verifikasi = now();
            $aplikasi->save();
        }
        return $aplikasi;
    }

    /**
     * Archive an application.
     *
     * @param mixed $id
     * @return mixed
     */
    public function archive($id): mixed
    {
        $aplikasi = $this->model->query()->find($id);
        if ($aplikasi) {
            $aplikasi->arsip = 1;
            $aplikasi->tanggal_diarsipkan = Carbon::now();
            $aplikasi->save();
        }
        return $aplikasi;
    }

    // --- New implementations for ArchiveController ---

    /**
     * Get paginated archived applications with optional filters.
     *
     * @param Request $request
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getArchivedPaginated(Request $request, int $perPage = 10): LengthAwarePaginator
    {
        return $this->applyFilters($request, true) // Pass true for archived query
                    ->orderBy('tanggal_diarsipkan', 'desc')
                    ->paginate($perPage);
    }

    /**
     * Find a specific archived application by ID with relations.
     *
     * @param mixed $id
     * @return mixed
     */
    public function findArchived($id): mixed
    {
        return $this->model->query()
            ->where('arsip', 1) // Ensure it's an archived item
            ->with(['kategori', 'users', 'fotoAplikasi', 'ulasan.user'])
            ->findOrFail($id);
    }

    /**
     * Unarchive an application.
     *
     * @param mixed $id
     * @return mixed
     */
    public function unarchive($id): mixed
    {
        $aplikasi = $this->model->query()->find($id);
        if ($aplikasi) {
            $aplikasi->arsip = 0;
            $aplikasi->tanggal_diarsipkan = null;
            $aplikasi->save();
        }
        return $aplikasi;
    }

    /**
     * Delete an application permanently from the archive.
     *
     * @param mixed $id
     * @return mixed
     */
    public function deleteArchived($id): mixed
    {
        $aplikasi = $this->model->query()->where('arsip', 1)->find($id);
        if ($aplikasi) {
            $aplikasi->delete();
        }
        return $aplikasi;
    }
}