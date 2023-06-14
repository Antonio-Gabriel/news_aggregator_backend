<?php

namespace App\Http\Controllers;

use App\Domain\Commands\ArticleCommand;
use App\Domain\System\Queries\Article\GetArticlesQuery;
use App\Domain\System\UseCases\Article\CreateArticleUsecase;
use App\Http\Errors\BadRequest;
use App\Http\Requests\ArticleRequest;
use App\Http\Resources\ArticleResource;
use Exception;

class ArticleController extends Controller
{
    use BadRequest;

    public function __construct(
        private GetArticlesQuery $getArticles,
        private CreateArticleUsecase $createArticle
    ) {
    }

    public function index()
    {
        $articles = $this->getArticles->execute();
        return ArticleResource::collection($articles);
    }

    public function store(ArticleRequest $requestDTO)
    {
        try {
            $requestDTO->validated();

            $articleCreated = $this->createArticle->execute(
                new ArticleCommand(...$requestDTO->only([
                    "title",
                    "description",
                    "source",
                    "author",
                    "category_id",
                    "url",
                    "url_image",
                    "published_at",
                ]))
            );

            $this->error_400($articleCreated);

            return response()->json($articleCreated);
        } catch (Exception $ex) {
            return response(content: $ex->getMessage(), status: 400);
        }
    }

    public function update(ArticleRequest $requestDTO, int $id)
    {
        //...
    }
}
