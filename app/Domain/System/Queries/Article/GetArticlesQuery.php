<?php

namespace App\Domain\System\Queries\Article;

use App\Domain\Interfaces\IArticleRepository;

class GetArticlesQuery
{
    public function __construct(
        private IArticleRepository $repository
    ) {
    }

    public function execute()
    {
        return $this->repository->get();
    }
}
