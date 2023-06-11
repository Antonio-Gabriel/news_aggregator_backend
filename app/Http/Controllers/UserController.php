<?php

namespace App\Http\Controllers;

use App\Domain\Commands\UserCommand;
use App\Domain\System\Queries\GetUsersQuery;
use App\Domain\System\UseCases\CreateUserUsecase;
use App\Http\Requests\UserRequest;

class UserController extends Controller
{
    public function __construct(
        private GetUsersQuery $usersQuery,
        private CreateUserUsecase $createUser
    ) {
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
     *         description="Users"              
     *     )     
     * )
     */
    public function index()
    {
        return response()->json([
            "users" => $this->usersQuery->execute()
        ]);
    }

    public function store(UserRequest $request)
    {
        try {
            $requestDto = $request->validated();

            $response = $this->createUser->execute(
                new UserCommand($requestDto['name'], $requestDto['email'], $requestDto['password'])
            );
        } catch (\App\Exceptions\UserAlreadyExists $ex) {
            return response(content: $ex->getMessage(), status: 400);
        }

        return response()->json($response);
    }

    public function show()
    {
        // get user by id
    }

    public function update()
    {
        // Update 
    }

    public function destroy()
    {
        // delete
    }
}
