<?php

namespace App\Domain\System\UseCases\Settings;

use App\Domain\Commands\SettingsCommand;
use App\Domain\Interfaces\ISettingsRepository;
use App\Domain\System\Queries\GetUserByIdQuery;
use App\Exceptions\User\UserDoesntExists;
use Illuminate\Support\Facades\Log;

use App\Exceptions\Settings\SettingsEverWasInitialized;

class CreateUserSettingsUsecase
{
    public function __construct(
        private ISettingsRepository $repository,
        private GetUserByIdQuery $userQuery
    ) {
    }

    public function execute(SettingsCommand $entity)
    {
        if (!$this->userQuery->execute($entity->user_id)) {
            Log::error("User not exists {$entity->user_id}");
            throw new UserDoesntExists('User not exists');
        }

        if ($this->repository->exists($entity->user_id)) {
            Log::error("User already has a setting base initialized {$entity->user_id}");
            throw new SettingsEverWasInitialized('User already initialized a settings config');
        }

        $entity->metadata = json_encode($entity->metadata);
        return $this->repository->create($entity);
    }
}
