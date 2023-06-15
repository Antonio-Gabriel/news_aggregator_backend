<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class SettingsRequest
 * @package App\Http\Requests
 * @OA\Schema(
 *     schema="SettingsRequest",
 *     type="object",
 *     title="Setting request",
 *     properties={
 *         @OA\Property(property="id", type="integer"),
 *         @OA\Property(property="user_id", type="string"),
 *         @OA\Property(property="metadata", type="string"),
 *         @OA\Property(property="created_at", type="string"),
 *         @OA\Property(property="updated_at", type="string")
 *     }
 * )
 * 
 * @OA\Schema(
 *     schema="SettingsRequestValidationError",
 *     type="object",
 *     title="Create SettingsRequestValidationError",
 *     properties={
 *         @OA\Property(property="errors", type="object", properties={
 *             @OA\Property(property="user_id", type="array", @OA\Items(type="integer")),
 *             @OA\Property(property="metadata", type="array", @OA\Items(type="string"))
 *         })
 *     }
 * )
 */

class SettingsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'user_id' => ['integer', 'required'],
            'metadata' => ['required']
        ];
    }
}
