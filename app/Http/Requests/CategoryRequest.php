<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class CategoryRequest
 * @package App\Http\Requests
 * @OA\Schema(
 *     schema="CategoryRequest",
 *     type="object",
 *     title="Category request",
 *     properties={
 *         @OA\Property(property="id", type="int"),
 *         @OA\Property(property="name", type="string"),
 *         @OA\Property(property="created_at", type="string"),
 *         @OA\Property(property="updated_at", type="string")
 *     }
 * )
 * 
 * @OA\Schema(
 *     schema="CategoryRequestValidationError",
 *     type="object",
 *     title="Create/Update CategoryRequestValidationError",
 *     properties={
 *         @OA\Property(property="errors", type="object", properties={
 *             @OA\Property(property="name", type="array", @OA\Items(type="string"))
 *         })
 *     }
 * )
 */

class CategoryRequest extends FormRequest
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
            'name' => ['required', 'min:6']
        ];
    }
}
