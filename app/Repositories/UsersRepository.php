<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Collection;
use App\Domain\Commands\UserCommand;
use Illuminate\Database\Eloquent\Model;
use App\Domain\Interfaces\IUserRepository;

class UsersRepository implements IUserRepository
{
    public function exists(string $email): bool
    {
        return User::where('email', $email)->exists();
    }

    public function get(): Collection
    {
        return User::all();
    }

    public function create(UserCommand $entity): ?Model
    {
        return User::create([
            "name" => $entity->name,
            "email" => $entity->email,
            "password" => $entity->password,
        ]);
    }

    public function update(UserCommand $entity, int $id): bool
    {
        return User::where('id', $id)
            ->update([
                "name" => $entity->name,
                "email" => $entity->email,
                "password" => $entity->password
            ]);
    }

    public function getByEmail(string $email): ?Model
    {
        return User::where('email', $email)->first();
    }

    public function getById(int $id): ?Model
    {
        return User::find($id);
    }
}
