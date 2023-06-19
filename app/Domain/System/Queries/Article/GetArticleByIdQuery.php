<?php

namespace App\Domain\System\Queries\Article;

use App\Domain\Interfaces\IArticleRepository;

class GetArticleByIdQuery
{
    public function __construct(
        private IArticleRepository $repository
    ) {
    }

    public function execute(int $id)
    {
        return $this->repository->getById($id);
    }
}
