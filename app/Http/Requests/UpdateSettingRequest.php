<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class UpdateSettingRequest
 * @package App\Http\Requests
 * @OA\Schema(
 *     schema="UpdateSettingRequestValidationError",
 *     type="object",
 *     title="Update UpdateSettingRequestValidationError",
 *     properties={
 *         @OA\Property(property="errors", type="object", properties={
 *             @OA\Property(property="metadata", type="array", @OA\Items(type="string"))
 *         })
 *     }
 * )
 */

class UpdateSettingRequest extends FormRequest
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
            'metadata' => ['required']
        ];
    }
}
