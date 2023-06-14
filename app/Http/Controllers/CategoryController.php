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

    /**     
     * @return Response
     * @OA\Get(
     *     path="/api/v1/categories",
     *     summary="List all categories",
     *     operationId="category/index",
     *     tags={"Categories"},     
     *     security={{"bearer_token":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(     
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/CategoryRequest")
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
        $categories = $this->getCategories->execute();

        return response()->json([
            'categories' => $categories
        ]);
    }

    /**     
     * @return Response
     * @OA\Post(
     *     path="/api/v1/categories",
     *     summary="Create new category",
     *     operationId="category/store",
     *     tags={"Categories"},
     *     security={{"bearer_token":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         description="Category object",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                  @OA\Property(
     *                     property="name",
     *                     type="string"
     *                 ),
     *             )
     *         )
     *     ),     
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(ref="#/components/schemas/CategoryRequest")         
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad request",
     *         @OA\JsonContent(ref="#/components/schemas/CategoryRequestValidationError")
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized",
     *         @OA\JsonContent(ref="#/components/schemas/AuthUserRequestValidationError")
     *     )              
     * )
     */
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

    /**     
     * @return Response
     * @OA\Put(
     *     path="/api/v1/categories/{id}",
     *     summary="Update category",
     *     operationId="category/update",
     *     tags={"Categories"},
     *     security={{"bearer_token":{}}},
     *     @OA\Parameter(
     *         description="Category id parameter",
     *         in="path",
     *         name="id",
     *         required=true     
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         description="Category object",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                  @OA\Property(
     *                     property="name",
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
     *         @OA\JsonContent(ref="#/components/schemas/CategoryRequestValidationError")
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized",
     *         @OA\JsonContent(ref="#/components/schemas/AuthUserRequestValidationError")
     *     )                   
     * )
     */
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
