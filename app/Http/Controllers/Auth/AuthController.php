<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthUserRequest;
use Exception;

class AuthController extends Controller
{
    public function signIn(AuthUserRequest $requestDTO)
    {
        try {
            $requestDTO->validated();
            $credentials = $requestDTO->only(['email', 'password']);

            if (!$token = auth()->attempt($credentials)) {
                return response()->json([
                    'error' => 'Unauthorized'
                ], 401);
            }

            return response()->json([
                'token' => $token,
                'token_type' => 'Bearer',
                'expires_in' => auth()->factory()->getTTL() * 60,
                'user' => $this->getMe()
            ]);
        } catch (Exception $ex) {
            response()->json([
                'error' => $ex->getMessage()
            ], 500);
        }
    }

    private function getMe()
    {
        return auth()->user();
    }

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
