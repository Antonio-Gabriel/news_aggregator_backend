<?php

namespace App\Providers\User;

use App\Domain\System\Queries\Settings\GetUserSettingsQuery;
use App\Domain\System\UseCases\AuthUserUsecase;
use App\Http\Controllers\Auth\AuthController;
use App\Repositories\SettingsRepository;
use Illuminate\Support\ServiceProvider;

class UserAuthProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(AuthController::class, function () {
            $settingsRepository = new SettingsRepository;

            // Queries
            $settingsQuery = new GetUserSettingsQuery($settingsRepository);

            $authUser = new AuthUserUsecase($settingsQuery);

            return new AuthController($authUser);
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
