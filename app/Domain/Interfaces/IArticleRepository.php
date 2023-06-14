<?php

namespace App\Domain\Interfaces;

use App\Domain\Commands\ArticleCommand;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface IArticleRepository
{
    public function get(): Collection;
    public function exists(string $title, int $categoryId): bool;
    public function getByFilters(array $filters): Collection;
    public function create(ArticleCommand $entity): ?Model;
    public function update(ArticleCommand $entity, int $id): bool;
}
