<?php

namespace App\Contracts\Interfaces;

use App\Contracts\Interfaces\Eloquent\BaseInterface;
use App\Contracts\Interfaces\Eloquent\FindByIdInterface;
use App\Contracts\Interfaces\Eloquent\FindInterface;
use App\Contracts\Interfaces\Eloquent\GetAllByAplikasiIdInterface;
use App\Contracts\Interfaces\Eloquent\GetByAplikasiIdInterface;
use App\Contracts\Interfaces\Eloquent\PaginateInterface;
use App\Contracts\Interfaces\Eloquent\WhereInterface;

interface FotoAplikasiInterface extends BaseInterface, WhereInterface, FindInterface, FindByIdInterface, GetByAplikasiIdInterface
{
    //
}