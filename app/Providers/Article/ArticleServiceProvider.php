<?php

namespace App\Providers\Article;

use App\Domain\System\Queries\Article\FilterArticlesQuery;
use App\Domain\System\Queries\Article\GetArticlesQuery;
use App\Domain\System\Queries\Category\GetCategoryByIdQuery;
use App\Domain\System\UseCases\Article\CreateArticleUsecase;
use App\Domain\System\UseCases\Article\UpdateArticleUsecase;
use App\Http\Controllers\ArticleController;
use App\Repositories\ArticleRepository;
use App\Repositories\CategoryRepository;
use Illuminate\Support\ServiceProvider;

class ArticleServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(ArticleController::class, function () {
            $articleRepository = new ArticleRepository;
            $categoryRepository = new CategoryRepository;

            // Queries
            $articlesQuery = new GetArticlesQuery($articleRepository);
            $categoryQuery = new GetCategoryByIdQuery($categoryRepository);
            $filterArticlesQuery = new FilterArticlesQuery($articleRepository);

            // Usecase
            $createArticle = new CreateArticleUsecase($articleRepository, $categoryQuery);
            $updateArticle = new UpdateArticleUsecase($articleRepository);

            return new ArticleController($articlesQuery, $createArticle, $updateArticle, $filterArticlesQuery);
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
