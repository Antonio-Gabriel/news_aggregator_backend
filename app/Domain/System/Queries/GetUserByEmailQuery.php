<?php

namespace App\Domain\System\Queries;

use App\Domain\Interfaces\IUserRepository;

class GetUserByEmailQuery
{
    public function __construct(
        private IUserRepository $repository
    ) {
    }

    public function execute(string $email)
    {
        return $this->repository->getByEmail($email);
    }
}
