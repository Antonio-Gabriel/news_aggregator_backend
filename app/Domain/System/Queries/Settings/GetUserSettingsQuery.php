<?php

namespace App\Domain\System\Queries\Settings;

use App\Domain\Interfaces\ISettingsRepository;

class GetUserSettingsQuery
{
    public function __construct(
        private ISettingsRepository $repository
    ) {
    }

    public function execute(int $userId)
    {
        return $this->repository->getByUser($userId);
    }
}
