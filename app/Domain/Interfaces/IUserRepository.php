<?php

namespace App\Domain\Interfaces;

use Illuminate\Support\Collection;
use App\Domain\Commands\UserCommand;
use Illuminate\Database\Eloquent\Model;

interface IUserRepository
{
    public function exists(string $email): bool;

    public function get(): Collection;

    public function create(UserCommand $entity): ?Model;

    public function update(UserCommand $entity, int $id): bool;

    public function getByEmail(string $email): ?Model;

    public function getById(int $id): ?Model;
}
