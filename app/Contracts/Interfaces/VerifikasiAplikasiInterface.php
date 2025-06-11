<?php

namespace App\Contracts\Interfaces;

use App\Contracts\Interfaces\Eloquent\BaseInterface;
use App\Contracts\Interfaces\Eloquent\GetByStatusInterface;
use App\Contracts\Interfaces\Eloquent\ShowInterface;
use App\Contracts\Interfaces\Eloquent\UpdateInterface;

interface VerifikasiAplikasiInterface extends GetByStatusInterface, ShowInterface, UpdateInterface {
    public function getByStatus(string $requeststatus);
    public function getAcceptedOrRejected(); 
}