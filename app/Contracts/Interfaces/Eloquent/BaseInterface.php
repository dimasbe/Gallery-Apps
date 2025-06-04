<?php 

namespace App\Contracts\Interfaces\Eloquent;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface BaseInterface extends 
    GetInterface,  
    StoreInterface, 
    ShowInterface, 
    UpdateInterface, 
    DeleteInterface,
    FilterInterface
{
}