<?php
namespace App\Contracts\Interfaces;

use App\Contracts\Interfaces\Eloquent\FindByEmailInterface;
use App\Contracts\Interfaces\Eloquent\GetCountInterface;
use App\Contracts\Interfaces\Eloquent\PasswordCheckerInterface;

interface UserInterface extends FindByEmailInterface, PasswordCheckerInterface, GetCountInterface
{
    public function create(array $data): \App\Models\User;
}
