<?php

namespace App\Domain\Interfaces;

use App\Domain\Commands\CategoryCommand;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface ICategoryRepository
{
    public function get(): Collection;
    public function getById(int $id): ?Model;
    public function exists(string $name): bool;
    public function create(CategoryCommand $entity): ?Model;
    public function update(CategoryCommand $entity, int $id): bool;
}
