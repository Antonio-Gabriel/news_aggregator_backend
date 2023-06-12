<?php

namespace App\Domain\System\Queries;

use App\Domain\Interfaces\IUserRepository;

class GetUserByIdQuery
{
    public function __construct(
        private IUserRepository $repository
    ) {
    }

    public function execute(int $id)
    {
        return $this->repository->getById($id);
    }
}
