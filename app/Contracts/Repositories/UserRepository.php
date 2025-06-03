<?php
namespace App\Contracts\Repositories;

use App\Contracts\Interfaces\UserInterface;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserRepository implements UserInterface
{
    public function findByEmail(string $email): ?User
    {
        return User::where('email', $email)->first();
    }

    public function checkPassword(string $inputPassword, string $hashedPassword): bool
    {
        return Hash::check($inputPassword, $hashedPassword);
    }

    public function create(array $data): User
    {
        $data['password'] = Hash::make($data['password']);
        return User::create($data);
    }
}
