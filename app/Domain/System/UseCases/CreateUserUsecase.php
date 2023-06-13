<?php

namespace App\Domain\System\UseCases;

use App\Domain\Commands\UserCommand;
use App\Domain\Interfaces\IUserRepository;
use App\Exceptions\User\UserAlreadyExists;
use Illuminate\Support\Facades\Log;

class CreateUserUsecase
{
    public function __construct(
        private IUserRepository $repository
    ) {
    }

    public function execute(UserCommand $user)
    {
        if ($this->repository->exists($user->email)) {
            Log::info("User already exists", [$user->email]);
            throw new UserAlreadyExists("User already exists");
        }

        $user->password = bcrypt($user->password);

        return $this->repository->create($user);
    }
}
