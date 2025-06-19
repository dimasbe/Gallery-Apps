<?php

namespace App\Contracts\Interfaces\Eloquent;

interface GetByAplikasiIdInterface
{
    public function getByAplikasiId(int $idAplikasi): mixed;
}