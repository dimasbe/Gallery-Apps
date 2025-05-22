<?php
namespace App\Contracts\Interfaces;

use App\Contracts\Interfaces\Eloquent\FindByEmailInterface;
use App\Contracts\Interfaces\Eloquent\PasswordCheckerInterface;

interface UserInterface extends FindByEmailInterface, PasswordCheckerInterface
{
    public function create(array $data): \App\Models\User;
}
