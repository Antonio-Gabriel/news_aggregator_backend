<?php

namespace App\Http\Controllers;

use App\Domain\Commands\ArticleCommand;
use App\Domain\System\Queries\Article\FilterArticlesQuery;
use App\Domain\System\Queries\Article\GetArticlesQuery;
use App\Domain\System\UseCases\Article\CreateArticleUsecase;
use App\Domain\System\UseCases\Article\UpdateArticleUsecase;
use App\Http\Errors\BadRequest;
use App\Http\Requests\ArticleRequest;
use App\Http\Resources\ArticleResource;
use Exception;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    use BadRequest;

    public function __construct(
        private GetArticlesQuery $getArticles,
        private CreateArticleUsecase $createArticle,
        private UpdateArticleUsecase $updateArticle,
        private FilterArticlesQuery $articlesQuery
    ) {
        $this->middleware('auth.protected', ['except' => ['index']]);
    }

    /**     
     * @return Response
     * @OA\Get(
     *     path="/api/v1/articles",
     *     summary="List all articles",
     *     operationId="article/index",
     *     tags={"Articles"},     
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

    /**     
     * @return Response
     * @OA\Put(
     *     path="/api/v1/articles/{id}",
     *     summary="Update articles",
     *     operationId="articles/update",
     *     tags={"Articles"},
     *     security={{"bearer_token":{}}},
     *     @OA\Parameter(
     *         description="Article id parameter",
     *         in="path",
     *         name="id",
     *         required=true     
     *     ),
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
     *         description="Success"        
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
    public function update(ArticleRequest $requestDTO, int $id)
    {
        try {
            $requestDTO->validated();

            $articleUpdated = $this->updateArticle->execute(
                new ArticleCommand(...$requestDTO->only([
                    "title",
                    "description",
                    "source",
                    "author",
                    "category_id",
                    "url",
                    "url_image",
                    "published_at",
                ])),
                $id
            );

            $this->error_400($articleUpdated);

            return response()->json("Article updated successfully");
        } catch (Exception $ex) {
            return response(content: $ex->getMessage(), status: 400);
        }
    }

    /**     
     * @return Response
     * @OA\Get(
     *     path="/api/v1/articles/customs",
     *     summary="List all custom articles",
     *     operationId="article/custom",
     *     tags={"Articles"},     
     *     security={{"bearer_token":{}}},
     *     @OA\Parameter(
     *         description="Sources parameter need to be separeted by comma, ex: a,b,c",
     *         in="query",
     *         name="sources"  
     *     ),
     *     @OA\Parameter(
     *         description="Authors parameter",
     *         in="query",
     *         name="authors"   
     *     ),
     *     @OA\Parameter(
     *         description="Categories parameter",
     *         in="query",
     *         name="categories"  
     *     ),
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
    public function custom(Request $request)
    {
        if (is_null($request->query())) {
            $articles = $this->getArticles->execute();
            return ArticleResource::collection($articles);
        }

        $sources = $request->query('sources');
        $categories = $request->query('categories');
        $authors = $request->query('authors');

        $query = $this->articlesQuery->query();
        $this->articlesQuery->applyFilters($query, 'source', $sources);
        $this->articlesQuery->applyFilters($query, 'author', $authors);
        $this->articlesQuery->applyFilters($query, 'category_id', $categories);

        $articles = $query->get();

        return ArticleResource::collection($articles);
    }
}
