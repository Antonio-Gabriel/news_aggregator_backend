<?php

namespace App\Domain\Interfaces;

use App\Domain\Commands\ArticleCommand;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface IArticleRepository
{
    public function get(): Collection;
    public function getById(int $id): ?Model;
    public function exists(string $title, int $categoryId): bool;
    public function getQuery();
    public function create(ArticleCommand $entity): ?Model;
    public function update(ArticleCommand $entity, int $id): bool;
}
