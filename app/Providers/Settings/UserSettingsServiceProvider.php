<?php

namespace App\Providers\Settings;

use App\Domain\System\Queries\GetUserByIdQuery;
use App\Domain\System\Queries\Settings\GetUserSettingsQuery;
use App\Domain\System\UseCases\Settings\CreateUserSettingsUsecase;
use App\Domain\System\UseCases\Settings\UpdateUserSettingsUsecase;
use App\Http\Controllers\SettingsController;
use App\Repositories\SettingsRepository;
use App\Repositories\UsersRepository;
use Illuminate\Support\ServiceProvider;

class UserSettingsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(SettingsController::class, function () {
            $settingsRepository = new SettingsRepository;
            $userRepository =  new UsersRepository;

            // Queries
            $settingsQuery = new GetUserSettingsQuery($settingsRepository);
            $userQuery = new GetUserByIdQuery($userRepository);

            // Usecases
            $createSetting = new CreateUserSettingsUsecase($settingsRepository, $userQuery);
            $updateSettings = new UpdateUserSettingsUsecase($settingsRepository);

            return new SettingsController($createSetting, $settingsQuery, $updateSettings);
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
