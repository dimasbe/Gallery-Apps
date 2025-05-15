<?php

namespace App\Contracts\Interfaces\Eloquent;

use Illuminate\Http\Request;

interface SearchInterface
{
    public function search(Request $request): mixed;
}