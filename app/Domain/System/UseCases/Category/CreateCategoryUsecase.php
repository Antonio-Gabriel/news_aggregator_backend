<?php

namespace App\Domain\System\UseCases\Category;

use App\Domain\Commands\CategoryCommand;
use App\Domain\Interfaces\ICategoryRepository;
use App\Exceptions\Category\CategoryAlreadyExists;
use Illuminate\Support\Facades\Log;

class CreateCategoryUsecase
{
    public function __construct(
        private ICategoryRepository $repository
    ) {
    }

    public function execute(CategoryCommand $entity)
    {
        if ($this->repository->exists($entity->name)) {
            Log::info("Category already exists: {$entity->name}");
            throw new CategoryAlreadyExists("Category already exists");
        }

        return $this->repository->create($entity);
    }
}
