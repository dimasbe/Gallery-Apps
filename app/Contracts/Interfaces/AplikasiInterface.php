<?php

namespace App\Contracts\Interfaces;

use App\Contracts\Interfaces\Eloquent\BaseInterface;
use App\Contracts\Interfaces\Eloquent\FindInterface;
use App\Contracts\Interfaces\Eloquent\GetByUserIdInterface;
use App\Contracts\Interfaces\Eloquent\SearchInterface;
use App\Contracts\Interfaces\Eloquent\WhereInterface;

interface AplikasiInterface extends BaseInterface, SearchInterface, FindInterface, GetByUserIdInterface
{
    //
}