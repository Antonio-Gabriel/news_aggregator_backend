<?php

namespace App\Domain\System\UseCases;

use Illuminate\Support\Facades\Log;
use Illuminate\Validation\UnauthorizedException;

class AuthUserUsecase
{
    public function execute(array $credentials)
    {
        if (!$token = auth()->attempt($credentials)) {
            Log::error("Unauthorized", [$credentials]);
            throw new UnauthorizedException("Unauthorized");
        }

        return [
            'user' => $this->getMe(),
            'authorization' => [
                'token' => $token,
                'type' => 'Bearer',
                'expires_in' => auth()->factory()->getTTL() * 60
            ]
        ];
    }

    private function getMe()
    {
        return auth()->user();
    }
}
