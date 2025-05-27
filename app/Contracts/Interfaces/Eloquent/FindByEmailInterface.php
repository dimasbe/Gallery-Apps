<?php
namespace App\Contracts\Interfaces\Eloquent;

interface FindByEmailInterface
{
    public function findByEmail(string $email): ?\App\Models\User;
}
