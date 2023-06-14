<?php

namespace App\Http\Controllers;

use App\Domain\Commands\UserCommand;
use App\Domain\System\Queries\GetUserByEmailQuery;
use App\Domain\System\Queries\GetUserByIdQuery;
use App\Domain\System\Queries\GetUsersQuery;
use App\Domain\System\UseCases\CreateUserUsecase;
use App\Domain\System\UseCases\DeleteUserUsecase;
use App\Domain\System\UseCases\UpdateUserUsecase;
use App\Exceptions\User\UserAlreadyExists;
use App\Exceptions\User\UserDoesntExists;
use App\Http\Requests\UserRequest;
use App\Http\Errors\BadRequest;


class UserController extends Controller
{
    use BadRequest;

    public function __construct(
        private GetUsersQuery $usersQuery,
        private GetUserByIdQuery $userById,
        private GetUserByEmailQuery $userQuery,
        private CreateUserUsecase $createUser,
        private UpdateUserUsecase $updateUser,
        private DeleteUserUsecase $deleteUser
    ) {
        $this->middleware('auth.protected', ['except' => ['store']]);
    }

    /**     
     * @return Response
     * @OA\Get(
     *     path="/api/v1/users",
     *     summary="List all users",
     *     operationId="index",
     *     tags={"Users"},     
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(     
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/UserRequest")
     *         ),          
     *     )         
     * )
     */
    public function index()
    {
        $users = $this->usersQuery->execute();

        return response()->json([
            "users" => $users
        ]);
    }

    /**     
     * @return Response
     * @OA\Post(
     *     path="/api/v1/users",
     *     summary="Create new user",
     *     operationId="store",
     *     tags={"Users"},
     *     @OA\RequestBody(
     *         required=true,
     *         description="User object",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                  @OA\Property(
     *                     property="name",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="email",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="password",
     *                     type="string"
     *                 ),
     *             )
     *         )
     *     ),     
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(ref="#/components/schemas/UserRequest")         
     *     )         
     * )
     */
    public function store(UserRequest $requestDTO)
    {
        try {
            $requestDTO->validated();

            $userCreated = $this->createUser->execute(
                new UserCommand(...$requestDTO->only([
                    "name",
                    "email",
                    "password"
                ]))
            );

            $this->error_400($userCreated);

            return response()->json($userCreated);
        } catch (UserAlreadyExists $ex) {
            return response(content: $ex->getMessage(), status: 400);
        }
    }

    /**     
     * @return Response
     * @OA\Get(
     *     path="/api/v1/users/{id}",
     *     summary="Get user by id",
     *     operationId="show",
     *     tags={"Users"},
     *     @OA\Parameter(
     *         description="User id parameter",
     *         in="path",
     *         name="id",
     *         required=true     
     *     ),
     *      
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(ref="#/components/schemas/UserRequest"),          
     *     ),
     * 
     *     @OA\Response(
     *         response=400,
     *         description="Bad request"
     *     )         
     * )
     */
    public function show(int $id)
    {
        $user = $this->userById->execute($id);
        return response()->json([
            "user" => $user
        ]);
    }

    /**     
     * @return Response
     * @OA\Put(
     *     path="/api/v1/users/{id}",
     *     summary="Update user",
     *     operationId="update",
     *     tags={"Users"},
     *     @OA\Parameter(
     *         description="User id parameter",
     *         in="path",
     *         name="id",
     *         required=true     
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         description="User object",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                  @OA\Property(
     *                     property="name",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="email",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="password",
     *                     type="string"
     *                 )
     *             )
     *         )
     *     ),     
     *     @OA\Response(
     *         response=200,
     *         description="Success"
     *     )         
     * )
     */
    public function update(UserRequest $requestDTO, int $userId)
    {
        try {
            $requestDTO->validated();
            $userUpdated = $this->updateUser->execute(
                new UserCommand(...$requestDTO->only([
                    "name",
                    "email",
                    "password"
                ])),
                $userId
            );

            $this->error_400($userUpdated);

            return response()->json("User updated successfully");
        } catch (UserDoesntExists $ex) {
            return response(content: $ex->getMessage(), status: 400);
        }
    }

    /**     
     * @return Response
     * @OA\Delete(
     *     path="/api/v1/users/{id}",
     *     summary="Delete user",
     *     operationId="destroy",
     *     tags={"Users"},
     *     @OA\Parameter(
     *         description="User id parameter",
     *         in="path",
     *         name="id",
     *         required=true     
     *     ),
     *      
     *     @OA\Response(
     *         response=200,
     *         description="Success"          
     *     ),
     * 
     *     @OA\Response(
     *         response=400,
     *         description="Bad request"
     *     )         
     * )
     */
    public function destroy(int $id)
    {
        try {
            $deletedUser = $this->deleteUser->execute($id);

            $this->error_400($deletedUser);

            return response()->json("User deleted successfully");
        } catch (UserDoesntExists $ex) {
            return response(content: $ex->getMessage(), status: 400);
        }
    }
}
