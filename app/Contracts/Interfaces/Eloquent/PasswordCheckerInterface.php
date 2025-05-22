<?php
namespace App\Contracts\Interfaces\Eloquent;

interface PasswordCheckerInterface
{
    public function checkPassword(string $inputPassword, string $hashedPassword): bool;
}
