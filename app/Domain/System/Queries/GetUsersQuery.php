<?php

namespace App\Domain\System\Queries;

use App\Domain\Interfaces\IUserRepository;
use Illuminate\Support\Collection;

class GetUsersQuery
{
    public function __construct(
        private IUserRepository $repository
    ) {
    }

    public function execute(): Collection
    {
        return $this->repository->get();
    }
}
