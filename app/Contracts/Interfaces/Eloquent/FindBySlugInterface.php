<?php

namespace App\Contracts\Interfaces\Eloquent;

interface FindBySlugInterface
{
    /**
     * Find a record by its slug.
     *
     * @param string $slug
     * @return mixed
     */
    public function findBySlug(string $slug): mixed;
}