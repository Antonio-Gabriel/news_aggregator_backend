<?php

namespace App\Domain\Interfaces;

use App\Domain\Commands\SettingsCommand;
use App\Domain\Commands\UpdateSettingsCommand;
use Illuminate\Database\Eloquent\Model;

interface ISettingsRepository
{
    public function create(SettingsCommand $entity): ?Model;
    public function getByUser(int $userId): ?Model;
    public function exists(int $userId): bool;
    public function update(UpdateSettingsCommand $entity, int $id): bool;
}
