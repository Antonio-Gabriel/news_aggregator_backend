<?php

namespace App\Domain\System\UseCases;

use App\Domain\System\Queries\Settings\GetUserSettingsQuery;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\UnauthorizedException;

class AuthUserUsecase
{
    public function __construct(
        private GetUserSettingsQuery $settingsQuery
    ) {
    }

    public function execute(array $credentials)
    {
        if (!$token = auth()->attempt($credentials)) {
            Log::error("Unauthorized", [$credentials]);
            throw new UnauthorizedException("Unauthorized");
        }

        $me = $this->getMe();
        $settings = $this->settingsQuery->execute($me->id);

        return [
            'user' => $me,
            'authorization' => [
                'token' => $token,
                'type' => 'Bearer',
                'expires_in' => auth()->factory()->getTTL() * 60
            ],
            'settings' => $settings
        ];
    }

    private function getMe()
    {
        return auth()->user();
    }
}
