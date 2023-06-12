<?php

namespace App\Providers\User;

use App\Domain\System\Queries\GetUserByEmailQuery;
use App\Domain\System\Queries\GetUserByIdQuery;
use App\Domain\System\Queries\GetUsersQuery;
use App\Domain\System\UseCases\CreateUserUsecase;
use App\Domain\System\UseCases\UpdateUserUsecase;
use App\Http\Controllers\UserController;
use App\Repositories\UsersRepository;
use Illuminate\Support\ServiceProvider;

class UsersServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(UserController::class, function () {
            $userRepository = new UsersRepository;

            // Queries
            $userQuery = new GetUsersQuery($userRepository);
            $userByEmailQuery = new GetUserByEmailQuery($userRepository);
            $userByIdQuery = new GetUserByIdQuery($userRepository);

            $createUserUsecase = new CreateUserUsecase($userRepository);
            $updateUserUsecase = new UpdateUserUsecase($userRepository);
            return new UserController(
                $userQuery,
                $userByIdQuery,
                $userByEmailQuery,
                $createUserUsecase,
                $updateUserUsecase
            );
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
