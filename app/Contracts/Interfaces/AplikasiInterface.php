<?php

namespace App\Contracts\Interfaces;

use App\Contracts\Interfaces\Eloquent\BaseInterface;
use App\Contracts\Interfaces\Eloquent\FindInterface;
use App\Contracts\Interfaces\Eloquent\GetByUserIdInterface;
use App\Contracts\Interfaces\Eloquent\GetCountInterface;
use App\Contracts\Interfaces\Eloquent\SearchInterface;
use App\Contracts\Interfaces\Eloquent\AplikasiQueryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator; // Added for pagination
use Illuminate\Http\Request; // Added for request parameter in methods
use Illuminate\Support\Collection;

interface AplikasiInterface extends
    BaseInterface,
    SearchInterface,
    FindInterface,
    GetByUserIdInterface,
    AplikasiQueryInterface,
    GetCountInterface
{
    /**
     * Get a number of the most popular applications based on visit count.
     *
     * @param int $limit The number of applications to retrieve.
     * @return \Illuminate\Support\Collection
     */
    public function getPopularApps(int $limit): Collection;

    /**
     * Mark an application as verified.
     *
     * @param mixed $id
     * @return mixed
     */
    public function verify($id): mixed;

    /**
     * Mark an application as rejected with a reason.
     *
     * @param mixed $id
     * @param string $reason
     * @return mixed
     */
    public function reject($id, string $reason): mixed;

    /**
     * Archive an application.
     *
     * @param mixed $id
     * @return mixed
     */
    public function archive($id): mixed;

    // --- New methods for ArchiveController ---

    /**
     * Get paginated archived applications with optional filters.
     *
     * @param Request $request
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getArchivedPaginated(Request $request, int $perPage = 10): LengthAwarePaginator;

    /**
     * Find a specific archived application by ID with relations.
     *
     * @param mixed $id
     * @return mixed
     */
    public function findArchived($id): mixed;

    /**
     * Unarchive an application.
     *
     * @param mixed $id
     * @return mixed
     */
    public function unarchive($id): mixed;

    /**
     * Delete an application permanently from the archive.
     *
     * @param mixed $id
     * @return mixed
     */
    public function deleteArchived($id): mixed;
}