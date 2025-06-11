<?php

namespace App\Contracts\Interfaces\Eloquent;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

interface AplikasiQueryInterface
{
    /**
     * Apply common filters and eager loads for Aplikasi queries.
     *
     * @param Request $request
     * @return Builder
     */
    public function applyFilters(Request $request): Builder;

    /**
     * Get paginated verified applications with filters.
     *
     * @param Request $request
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getVerifiedPaginated(Request $request, int $perPage = 10): LengthAwarePaginator;

    /**
     * Find a verified application by ID with relations.
     *
     * @param mixed $id
     * @return mixed
     */
    public function findVerified($id): mixed;
}