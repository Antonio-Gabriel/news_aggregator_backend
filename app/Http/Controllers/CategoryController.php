<?php

namespace App\Http\Controllers;

use App\Domain\Commands\CategoryCommand;
use App\Domain\System\Queries\Category\GetCategoriesQuery;
use App\Domain\System\Queries\Category\GetCategoryByIdQuery;
use App\Domain\System\UseCases\Category\CreateCategoryUsecase;
use App\Domain\System\UseCases\Category\UpdateCategoryUsecase;
use App\Exceptions\Category\CategoryAlreadyExists;
use App\Exceptions\CategoryDoesntExists;
use App\Http\Errors\BadRequest;
use App\Http\Requests\CategoryRequest;
use Exception;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    use BadRequest;

    public function __construct(
        private CreateCategoryUsecase $createCategory,
        private UpdateCategoryUsecase $updateCategory,
        private GetCategoriesQuery $getCategories,
        private GetCategoryByIdQuery $getCategory
    ) {
    }

    public function index()
    {
        $categories = $this->getCategories->execute();

        return response()->json([
            'categories' => $categories
        ]);
    }

    public function store(CategoryRequest $requestDTO)
    {
        try {
            $requestDTO->validated();
            $categoryCreated = $this->createCategory->execute(
                new CategoryCommand(...$requestDTO->only(['name']))
            );

            $this->error_400($categoryCreated);

            return response()->json($categoryCreated);
        } catch (CategoryAlreadyExists $ex) {
            return response(content: $ex->getMessage(), status: 400);
        }
    }

    public function update(CategoryRequest $requestDTO, int $id)
    {
        try {
            $requestDTO->validated();
            $categoryUpdated = $this->updateCategory->execute(
                new CategoryCommand(...$requestDTO->only(['name'])),
                $id
            );

            $this->error_400($categoryUpdated);

            return response()->json('Category updated successfully');
        } catch (Exception $ex) {
            if ($ex instanceof CategoryDoesntExists) return response($ex->getMessage(), status: 400);
            return response($ex->getMessage(), status: 400);
        }
    }
}
