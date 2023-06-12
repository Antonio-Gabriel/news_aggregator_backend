<?php

namespace App\Domain\System\UseCases;

use App\Domain\Commands\UserCommand;
use App\Domain\Interfaces\IUserRepository;
use App\Exceptions\User\UserDoesntExists;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class UpdateUserUsecase
{
    public function __construct(
        private IUserRepository $repository
    ) {
    }

    public function execute(UserCommand $user, int $id)
    {
        if (!$this->repository->exists($user->email)) {
            Log::info("User doesn't exists", [$user->email]);
            throw new UserDoesntExists("User doesn't exists");
        }

        return $this->repository->update($user, $id);
    }
}
