<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;


/**
 * Class UserRequest
 * @package App\Http\Requests
 * @OA\Schema(
 *     schema="UserRequest",
 *     type="object",
 *     title="Create/Update UserRequest",
 *     required={"name", "email", "password"},
 *     properties={
 *         @OA\Property(property="id", type="int"),
 *         @OA\Property(property="name", type="string"),
 *         @OA\Property(property="email", type="string"),
 *         @OA\Property(property="created_at", type="string"),
 *         @OA\Property(property="updated_at", type="string")
 *     }
 * )
 * @OA\Schema(
 *     schema="UserRequestValidationError",
 *     type="object",
 *     title="Create/Update UserRequestValidationError",
 *     properties={
 *         @OA\Property(property="errors", type="object", properties={
 *             @OA\Property(property="name", type="array", @OA\Items(type="string")),
 *             @OA\Property(property="email", type="array", @OA\Items(type="string")),
 *             @OA\Property(property="password", type="array", @OA\Items(type="string"))
 *         })
 *     }
 * )
 */

class UserRequest extends FormRequest
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
            'name' => ['required', 'min:3'],
            'email' => ['required', 'email'],
            'password' => ['required', 'min:6']
        ];
    }
}
