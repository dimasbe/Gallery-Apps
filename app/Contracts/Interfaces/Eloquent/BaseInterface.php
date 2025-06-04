<?php

namespace App\Contracts\Interfaces\Eloquent;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

<<<<<<< HEAD
interface BaseInterface extends 
    GetInterface,  
    StoreInterface, 
    ShowInterface, 
    UpdateInterface, 
    DeleteInterface,
    FilterInterface
=======
interface BaseInterface
>>>>>>> 4843355f112b0d9509923708636ccbd06a4bee32
{
    public function get(): mixed;
    public function find(mixed $id): mixed;
    public function store(array $data): mixed;
    public function update($id, array $data): mixed;
    public function delete($id): mixed;
}
