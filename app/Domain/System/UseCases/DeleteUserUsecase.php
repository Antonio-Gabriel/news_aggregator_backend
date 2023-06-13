<?php

namespace App\Domain\System\UseCases;

use App\Domain\Interfaces\IUserRepository;
use App\Exceptions\User\UserDoesntExists;
use Illuminate\Support\Facades\Log;

class DeleteUserUsecase
{
    public function __construct(
        private IUserRepository $repository
    ) {
    }

    public function execute(int $id)
    {
        if (!$this->repository->getById($id)) {
            Log::info("User doesn't exists", [$id]);
            throw new UserDoesntExists("User doesn't exists");
        }

        return $this->repository->delete($id);
    }
}
