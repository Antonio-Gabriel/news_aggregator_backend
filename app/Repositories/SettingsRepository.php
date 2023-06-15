<?php

namespace App\Repositories;

use App\Domain\Commands\SettingsCommand;
use App\Domain\Commands\UpdateSettingsCommand;
use App\Domain\Interfaces\ISettingsRepository;
use App\Models\Settings;
use Illuminate\Database\Eloquent\Model;

class SettingsRepository implements ISettingsRepository
{

    public function create(SettingsCommand $entity): ?Model
    {
        return Settings::create([
            'user_id' => $entity->user_id,
            'metadata' => $entity->metadata
        ]);
    }

    public function exists(int $userId): bool
    {
        return Settings::where('user_id', $userId)->exists();
    }

    public function getByUser(int $userId): ?Model
    {
        return Settings::where('user_id', $userId)->first();
    }

    public function update(UpdateSettingsCommand $entity, int $id): bool
    {
        return Settings::where('id', $id)
            ->update([
                'metadata' => $entity->metadata
            ]);
    }
}
