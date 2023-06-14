<?php

namespace App\Providers\User;

use App\Domain\System\UseCases\AuthUserUsecase;
use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\ServiceProvider;

class UserAuthProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(AuthController::class, function () {
            $authUser = new AuthUserUsecase;

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
