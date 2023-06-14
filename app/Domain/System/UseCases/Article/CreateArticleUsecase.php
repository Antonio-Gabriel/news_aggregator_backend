<?php

namespace App\Domain\System\UseCases\Article;

use App\Domain\Commands\ArticleCommand;
use App\Domain\Interfaces\IArticleRepository;
use App\Domain\System\Queries\Category\GetCategoryByIdQuery;
use App\Exceptions\ArticleAlreadyExists;
use App\Exceptions\CategoryDoesntExists;
use Illuminate\Support\Facades\Log;

class CreateArticleUsecase
{
    public function __construct(
        private IArticleRepository $repository,
        private GetCategoryByIdQuery $categoryQuery
    ) {
    }

    public function execute(ArticleCommand $entity)
    {
        if (!$this->categoryQuery->execute($entity->category_id)) {
            Log::warning("Category filled don't exist {$entity->category_id}");
            throw new CategoryDoesntExists("Category filled don't exist");
        }

        if ($this->repository->exists($entity->title, $entity->category_id)) {
            Log::info("Article already exists on this category");
            throw new ArticleAlreadyExists("Article already exists on this category");
        }

        return $this->repository->create($entity);
    }
}
