<?php

namespace App\Contracts\Interfaces\Eloquent;

interface FindByIdInterface
{
    /**
     * Cari data berdasarkan ID.
     *
     * @param int $id
     * @return mixed
     */
    public function findById(int $id);
}
