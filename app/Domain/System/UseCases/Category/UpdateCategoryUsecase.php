<?php

namespace App\Domain\System\UseCases\Category;

use App\Domain\Commands\CategoryCommand;
use App\Domain\Interfaces\ICategoryRepository;
use App\Exceptions\Category\CategoryAlreadyExists;
use App\Exceptions\CategoryDoesntExists;
use Illuminate\Support\Facades\Log;

class UpdateCategoryUsecase
{
    public function __construct(
        private ICategoryRepository $repository
    ) {
    }

    public function execute(CategoryCommand $entity, int $id)
    {
        if (!$this->repository->getById($id)) {
            Log::info("Category doesn't exists {$id}");
            throw new CategoryDoesntExists("Category doesn't exists");
        }

        $this->isAnExistentValue($entity->name);

        return $this->repository->update($entity, $id);
    }

    private function isAnExistentValue(string $name)
    {
        if ($this->repository->exists($name)) {
            Log::info("Category can't be changed, ever exists {$name}");
            throw new CategoryAlreadyExists("Category can't be changed, ever exists");
        }
    }
}
