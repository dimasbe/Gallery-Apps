<?php

namespace App\Contracts\Interfaces\Eloquent;

use Illuminate\Support\Collection;

interface GetAllByAplikasiIdInterface
{
public function getAllByAplikasiId(int $aplikasiId): Collection;
}