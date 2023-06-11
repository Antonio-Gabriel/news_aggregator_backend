<?php

namespace App\Providers;

use App\Domain\Commands\UserCommand;
use App\Domain\Interfaces\IUserRepository;
use App\Domain\System\Queries\GetUsersQuery;
use App\Domain\System\UseCases\CreateUserUsecase;
use App\Http\Controllers\UserController;
use App\Http\Requests\UserRequestDto;
use App\Repositories\UsersRepository;

use Illuminate\Support\ServiceProvider;

class UserServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(UserController::class, function ($app) {
            $userRepository = new UsersRepository;

            $userQuery = new GetUsersQuery($userRepository);
            $createUserUseCase = new CreateUserUsecase($userRepository);
            return new UserController($userQuery, $createUserUseCase);
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
