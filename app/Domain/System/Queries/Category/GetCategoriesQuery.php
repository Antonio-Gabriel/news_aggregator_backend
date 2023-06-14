<?php

namespace App\Domain\System\Queries\Category;

use App\Domain\Interfaces\ICategoryRepository;

class GetCategoriesQuery
{
    public function __construct(
        private ICategoryRepository $repository
    ) {
    }

    public function execute()
    {
        return $this->repository->get();
    }
}
