<?php

namespace App\Domain\System\UseCases;

use App\Domain\Commands\UserCommand;
use App\Domain\Interfaces\IUserRepository;
use App\Exceptions\User\UserDoesntExists;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UpdateUserUsecase
{
    public function __construct(
        private IUserRepository $repository
    ) {
    }

    public function execute(UserCommand $user, int $id)
    {
        if (!$this->repository->getById($id)) {
            Log::info("User doesn't exists", [$id]);
            throw new UserDoesntExists("User doesn't exists");
        }

        $user->password = $this->isUpdatedPassword($user, $id);

        return $this->repository->update($user, $id);
    }

    private function isUpdatedPassword(UserCommand $user, int $id)
    {
        $userData = $this->repository->getById($id);

        if (!Hash::check($user->password, $userData->password)) {
            return bcrypt($user->password);
        }

        return $userData->password;
    }
}
