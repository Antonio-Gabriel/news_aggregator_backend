<?php

namespace App\Repositories;

use App\Domain\Commands\CategoryCommand;
use App\Domain\Interfaces\ICategoryRepository;
use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class CategoryRepository implements ICategoryRepository
{
    public function get(): Collection
    {
        return Category::all();
    }

    public function getById(int $id): ?Model
    {
        return Category::find($id);
    }

    public function exists(string $name): bool
    {
        return Category::where('name', $name)->exists();
    }

    public function create(CategoryCommand $entity): ?Model
    {
        return Category::create(['name' => $entity->name]);
    }

    public function update(CategoryCommand $entity, int $id): bool
    {
        return Category::where('id', $id)
            ->update([
                'name' => $entity->name
            ]);
    }
}
