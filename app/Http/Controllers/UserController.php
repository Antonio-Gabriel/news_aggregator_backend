<?php

namespace App\Http\Controllers;

use App\Domain\Commands\UserCommand;
use App\Domain\System\Queries\GetUserByEmailQuery;
use App\Domain\System\Queries\GetUserByIdQuery;
use App\Domain\System\Queries\GetUsersQuery;
use App\Domain\System\UseCases\CreateUserUsecase;
use App\Domain\System\UseCases\UpdateUserUsecase;
use App\Exceptions\User\UserAlreadyExists;
use App\Exceptions\User\UserDoesntExists;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function __construct(
        private GetUsersQuery $usersQuery,
        private GetUserByIdQuery $userById,
        private GetUserByEmailQuery $userQuery,
        private CreateUserUsecase $createUser,
        private UpdateUserUsecase $updateUser
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
        $users = $this->usersQuery->execute();

        return response()->json([
            "users" => $users
        ]);
    }

    public function store(UserRequest $request)
    {
        try {
            $requestDto = $request->validated();

            $response = $this->createUser->execute(
                new UserCommand($requestDto['name'], $requestDto['email'], $requestDto['password'])
            );
        } catch (UserAlreadyExists $ex) {
            return response(content: $ex->getMessage(), status: 400);
        }

        return response()->json($response);
    }

    public function show(int $id)
    {
        $user = $this->userById->execute($id);
        return response()->json([
            "user" => $user
        ]);
    }

    public function update(UserRequest $requestDto, int $userId)
    {
        try {
            $userUpdated = $this->updateUser->execute(
                new UserCommand(
                    $requestDto['name'],
                    $requestDto['email'],
                    bcrypt($requestDto['password'])
                ),
                $userId
            );

            if (!$userUpdated) {
                Log::error("An error occured on update process");
                return response("An error occured!", status: 400);
            }
        } catch (UserDoesntExists $ex) {
            return response(content: $ex->getMessage(), status: 400);
        }

        return response()->json("User updated successfully");
    }

    public function destroy()
    {
        // delete
    }
}
