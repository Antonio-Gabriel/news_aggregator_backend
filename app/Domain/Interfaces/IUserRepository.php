<?php

namespace App\Domain\Interfaces;

use Ramsey\Uuid\Guid\Guid;
use Illuminate\Support\Collection;
use App\Domain\Commands\UserCommand;
use Illuminate\Database\Eloquent\Model;

interface IUserRepository
{
    public function exists(string $email): bool;

    public function get(): Collection;

    public function create(UserCommand $entity): ?Model;

    public function getById(Guid $userId): ?Model;
}
