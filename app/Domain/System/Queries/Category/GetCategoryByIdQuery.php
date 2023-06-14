<?php

namespace App\Domain\System\Queries\Category;

use App\Domain\Interfaces\ICategoryRepository;

class GetCategoryByIdQuery
{
    public function __construct(
        private ICategoryRepository $repository
    ) {
    }

    public function execute(int $id)
    {
        return $this->repository->getById($id);
    }
}
