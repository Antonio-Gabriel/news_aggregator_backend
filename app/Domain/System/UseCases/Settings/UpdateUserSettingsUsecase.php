<?php

namespace App\Domain\System\UseCases\Settings;

use App\Domain\Commands\SettingsCommand;
use App\Domain\Commands\UpdateSettingsCommand;
use App\Domain\Interfaces\ISettingsRepository;

use App\Exceptions\Settings\SettingsdoesntExists;
use Illuminate\Support\Facades\Log;

class UpdateUserSettingsUsecase
{
    public function __construct(
        private ISettingsRepository $repository
    ) {
    }

    public function execute(UpdateSettingsCommand $entity, int $id)
    {
        if (!$this->repository->exists($id)) {
            Log::error("Setting dont exists {$id}");
            throw new SettingsdoesntExists("Settings don't exists");
        }

        $entity->metadata = json_encode($entity->metadata);
        return $this->repository->update($entity, $id);
    }
}
