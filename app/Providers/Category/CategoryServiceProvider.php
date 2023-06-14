<?php

namespace App\Providers\Category;

use App\Domain\System\Queries\Category\GetCategoriesQuery;
use App\Domain\System\Queries\Category\GetCategoryByIdQuery;
use App\Domain\System\UseCases\Category\CreateCategoryUsecase;
use App\Domain\System\UseCases\Category\UpdateCategoryUsecase;
use App\Http\Controllers\CategoryController;
use App\Repositories\CategoryRepository;
use Illuminate\Support\ServiceProvider;

class CategoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(CategoryController::class, function () {
            $repository = new CategoryRepository;

            // Queries
            $getCategories = new GetCategoriesQuery($repository);
            $getCategory = new GetCategoryByIdQuery($repository);

            // Usecase
            $createCategory = new CreateCategoryUsecase($repository);
            $updateCategory = new UpdateCategoryUsecase($repository);

            return new CategoryController($createCategory, $updateCategory, $getCategories, $getCategory);
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
