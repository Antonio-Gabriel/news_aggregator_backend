<?php

namespace App\Factories;

use App\Domain\System\Queries\Category\GetCategoryByIdQuery;
use App\Domain\System\UseCases\Article\CreateArticleUsecase;
use App\Repositories\ArticleRepository;
use App\Repositories\CategoryRepository;

class CreateArticleFactory
{
    protected static CreateArticleUsecase $articleUsecase;

    private function __construct()
    {
        $articleRepository = new ArticleRepository;
        $categoriesRepository = new CategoryRepository;

        $categoriesQuery = new GetCategoryByIdQuery($categoriesRepository);
        self::$articleUsecase = new CreateArticleUsecase($articleRepository, $categoriesQuery);
    }

    public static function factory(): CreateArticleUsecase
    {
        $factory = new self();
        $factory->__construct();
        return self::$articleUsecase;
    }
}
