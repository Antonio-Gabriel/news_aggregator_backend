<?php

namespace App\Providers\Article;

use App\Domain\System\Queries\Article\GetArticlesQuery;
use App\Domain\System\Queries\Category\GetCategoryByIdQuery;
use App\Domain\System\UseCases\Article\CreateArticleUsecase;
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


            // Usecase
            $createArticle = new CreateArticleUsecase($articleRepository, $categoryQuery);

            return new ArticleController($articlesQuery, $createArticle);
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
