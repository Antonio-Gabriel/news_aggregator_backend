<?php

namespace App\Repositories;

use App\Domain\Commands\ArticleCommand;
use App\Domain\Interfaces\IArticleRepository;
use App\Models\Article;
use DateTime;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class ArticleRepository implements IArticleRepository
{
    public function get(): Collection
    {
        return Article::all();
    }

    public function getById(int $id): ?Model
    {
        return Article::find($id);
    }

    public function exists(string $title, int $categoryId): bool
    {
        return Article::where([
            'title' => $title,
            'category_id' => $categoryId
        ])->exists();
    }

    public function getQuery()
    {
        return Article::query();
    }

    public function create(ArticleCommand $entity): ?Model
    {
        return Article::create([
            'title' => $entity->title,
            'description' => $entity->description,
            'source' => $entity->source,
            'author' => $entity->author,
            'category_id' => $entity->category_id,
            'url' => $entity->url,
            'url_image' => $entity->url_image,
            'published_at' => new DateTime($entity->published_at)
        ]);
    }

    public function update(ArticleCommand $entity, int $id): bool
    {
        return Article::where('id', $id)
            ->update([
                'title' => $entity->title,
                'description' => $entity->description,
                'source' => $entity->source,
                'author' => $entity->author,
                'category_id' => $entity->category_id,
                'url' => $entity->url,
                'url_image' => $entity->url_image,
                'published_at' => new DateTime($entity->published_at)
            ]);
    }
}
