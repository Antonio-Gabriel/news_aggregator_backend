<?php

namespace App\Http\Controllers;

use App\Domain\Commands\SettingsCommand;
use App\Domain\Commands\UpdateSettingsCommand;
use App\Domain\System\Queries\Settings\GetUserSettingsQuery;
use App\Domain\System\UseCases\Settings\CreateUserSettingsUsecase;
use App\Domain\System\UseCases\Settings\UpdateUserSettingsUsecase;
use App\Http\Errors\BadRequest;
use App\Http\Requests\SettingsRequest;
use App\Http\Requests\UpdateSettingRequest;
use Exception;

class SettingsController extends Controller
{
    use BadRequest;

    public function __construct(
        private CreateUserSettingsUsecase $createSettings,
        private GetUserSettingsQuery $settingsQuery,
        private UpdateUserSettingsUsecase $updateSettings
    ) {
    }

    /**     
     * @return Response
     * @OA\Get(
     *     path="/api/v1/users/settings/{userId}",
     *     summary="Get user settings by id",
     *     operationId="settings/show",
     *     tags={"Settings"},
     *     security={{"bearer_token":{}}},
     *     @OA\Parameter(
     *         description="User id parameter",
     *         in="path",
     *         name="userId",
     *         required=true     
     *     ),
     *      
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(ref="#/components/schemas/SettingsRequest"),          
     *     ),
     * 
     *     @OA\Response(
     *         response=400,
     *         description="Bad request"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized",
     *         @OA\JsonContent(ref="#/components/schemas/SettingsRequestValidationError")
     *     )             
     * )
     */
    public function show(int $userId)
    {
        $setting = $this->settingsQuery->execute($userId);
        return response()->json([
            'setting' => $setting
        ]);
    }

    /**     
     * @return Response
     * @OA\Post(
     *     path="/api/v1/users/settings",
     *     summary="Create user settings",
     *     operationId="settings/store",
     *     tags={"Settings"},
     *     @OA\RequestBody(
     *         required=true,
     *         description="Settings object",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                  @OA\Property(
     *                     property="user_id",
     *                     type="integer"
     *                 ),
     *                 @OA\Property(
     *                     property="metadata",
     *                     type="json"
     *                 )
     *             )
     *         )
     *     ),     
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(ref="#/components/schemas/SettingsRequest")         
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad request",
     *         @OA\JsonContent(ref="#/components/schemas/SettingsRequestValidationError")
     *     ),              
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized",
     *         @OA\JsonContent(ref="#/components/schemas/SettingsRequestValidationError")
     *     )
     * )
     */
    public function store(SettingsRequest $requestDTO)
    {
        try {
            $requestDTO->validated();

            $settingsCreated = $this->createSettings->execute(
                new SettingsCommand(...$requestDTO->only([
                    "user_id",
                    "metadata"
                ]))
            );

            $this->error_400($settingsCreated);

            return response()->json($settingsCreated);
        } catch (Exception $ex) {
            return response(content: $ex->getMessage(), status: 400);
        }
    }

    /**     
     * @return Response
     * @OA\Put(
     *     path="/api/v1/users/settings/{id}",
     *     summary="Update user settings",
     *     operationId="settings/update",
     *     tags={"Settings"},
     *     security={{"bearer_token":{}}},
     *     @OA\Parameter(
     *         description="Setting id parameter",
     *         in="path",
     *         name="id",
     *         required=true     
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         description="Setting object",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                  @OA\Property(
     *                     property="metadata",
     *                     type="json"
     *                 )
     *             )
     *         )
     *     ),     
     *     @OA\Response(
     *         response=200,
     *         description="Success"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad request",
     *         @OA\JsonContent(ref="#/components/schemas/UpdateSettingRequestValidationError")
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized",
     *         @OA\JsonContent(ref="#/components/schemas/AuthUserRequestValidationError")
     *     )                   
     * )
     */
    public function update(UpdateSettingRequest $requestDTO, int $id)
    {
        try {
            $requestDTO->validated();
            $settingUpdated = $this->updateSettings->execute(
                new UpdateSettingsCommand(...$requestDTO->only([
                    "metadata"
                ])),
                $id
            );

            $this->error_400($settingUpdated);

            return response()->json("Setting updated successfully");
        } catch (Exception $ex) {
            return response(content: $ex->getMessage(), status: 400);
        }
    }
}
