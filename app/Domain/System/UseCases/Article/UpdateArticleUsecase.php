<?php

namespace App\Domain\System\UseCases\Article;

use App\Domain\Commands\ArticleCommand;
use App\Domain\Interfaces\IArticleRepository;
use Illuminate\Support\Facades\Log;

use App\Exceptions\Article\ArticleDoesntExists;

class UpdateArticleUsecase
{
    public function __construct(
        private IArticleRepository $repository
    ) {
    }

    public function execute(ArticleCommand $entity, int $id)
    {
        if (!$this->repository->getById($id)) {
            Log::info("Article doesn't exists", [$id]);
            throw new ArticleDoesntExists("Article doesn't exists");
        }

        return $this->repository->update($entity, $id);
    }
}
