<?php
namespace App\Contracts\Repositories;

use App\Contracts\Interfaces\UserInterface;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Model;

class UserRepository extends BaseRepository implements UserInterface
{
    protected Model $model;

    public function __construct(User $user)
    {
        $this->model = $user;
    }

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

    public function getCount(): int{
        return $this->model->where('role', '!=', 'admin')->count();
    }
}
