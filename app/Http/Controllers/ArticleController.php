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

    /**     
     * @return Response
     * @OA\Get(
     *     path="/api/v1/articles",
     *     summary="List all articles",
     *     operationId="article/index",
     *     tags={"Articles"},     
     *     security={{"bearer_token":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(     
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/ArticleResource")
     *         ),          
     *     ),
     *      @OA\Response(
     *         response=401,
     *         description="Unauthorized",
     *         @OA\JsonContent(ref="#/components/schemas/AuthUserRequestValidationError")
     *     )              
     * )
     */
    public function index()
    {
        $articles = $this->getArticles->execute();
        return ArticleResource::collection($articles);
    }

    /**     
     * @return Response
     * @OA\Post(
     *     path="/api/v1/articles",
     *     summary="Create new articles",
     *     operationId="articles/store",
     *     tags={"Articles"},
     *     security={{"bearer_token":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         description="Article object",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                  @OA\Property(
     *                     property="title",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="description",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="source",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="author",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="category_id",
     *                     type="integer"
     *                 ),
     *                 @OA\Property(
     *                     property="url",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="url_image",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="published_at",
     *                     type="string"
     *                 ),
     *             )
     *         )
     *     ),     
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(ref="#/components/schemas/ArticleResource")         
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad request",
     *         @OA\JsonContent(ref="#/components/schemas/ArticleResourceValidationError")
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized",
     *         @OA\JsonContent(ref="#/components/schemas/AuthUserRequestValidationError")
     *     )              
     * )
     */
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

            return response()->json(new ArticleResource($articleCreated));
        } catch (Exception $ex) {
            return response(content: $ex->getMessage(), status: 400);
        }
    }

    
    public function update(ArticleRequest $requestDTO, int $id)
    {
        //...
    }
}
