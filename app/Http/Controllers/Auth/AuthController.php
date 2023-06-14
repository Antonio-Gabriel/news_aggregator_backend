<?php

namespace App\Http\Controllers\Auth;

use App\Domain\System\UseCases\AuthUserUsecase;
use App\Http\Controllers\Controller;
use App\Http\Requests\AuthUserRequest;
use Exception;
use Illuminate\Validation\UnauthorizedException;

class AuthController extends Controller
{
    public function __construct(
        private AuthUserUsecase $authUser
    ) {
    }

    /**     
     * @return Response
     * @OA\Post(
     *     path="/api/login",
     *     summary="Authenticate user",
     *     operationId="signIn",
     *     tags={"Auth"},
     *     @OA\RequestBody(
     *         required=true,
     *         description="User object",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
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
     *         @OA\JsonContent(ref="#/components/schemas/AuthUserRequest")         
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorired",
     *         @OA\JsonContent(ref="#/components/schemas/AuthUserRequestValidationError")
     *     )              
     * )
     */
    public function signIn(AuthUserRequest $requestDTO)
    {
        try {
            $requestDTO->validated();
            $credentials = $requestDTO->only(['email', 'password']);

            $payload = $this->authUser->execute($credentials);

            return response()->json($payload);
        } catch (Exception $ex) {
            if ($ex instanceof UnauthorizedException) {
                return response()->json([
                    'error' => 'Unauthorized'
                ], 401);
            }

            return response()->json([
                'error' => $ex->getMessage()
            ], 500);
        }
    }

    /**     
     * @return Response
     * @OA\Post(
     *     path="/api/logout",
     *     summary="Logout user",
     *     operationId="signOut",
     *     tags={"Auth"},
     *     security={{"bearer_token":{}}},    
     *     @OA\Response(
     *         response=200,
     *         description="Success"              
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorired",
     *         @OA\JsonContent(ref="#/components/schemas/AuthUserRequestValidationError")
     *     )              
     * )
     */
    public function signOut()
    {
        try {
            auth()->logout();
            return response()->json("Logout successfully");
        } catch (Exception $ex) {
            return response()->json([
                'error' => $ex->getMessage()
            ], 500);
        }
    }
}
