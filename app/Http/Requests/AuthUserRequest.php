<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class AuthUserRequest
 * @package App\Http\Requests
 * @OA\Schema(
 *     schema="AuthUserRequest",
 *     type="object",
 *     title="Auth user request",
 *     properties={
 *         @OA\Property(property="user", type="object", properties={
 *              @OA\Property(property="id", type="int"),
 *              @OA\Property(property="name", type="string"),
 *              @OA\Property(property="email", type="string"),
 *              @OA\Property(property="created_at", type="string"),
 *              @OA\Property(property="updated_at", type="string") 
 *         }),
 *         @OA\Property(property="authentication", type="object", properties={
 *              @OA\Property(property="token", type="string"),
 *              @OA\Property(property="type", type="string"),
 *              @OA\Property(property="expires_in", type="int"),
 *         })
 *     }
 * )
 * @OA\Schema(
 *     schema="AuthUserRequestValidationError",
 *     type="object",
 *     title="AuthUserRequestValidationError",
 *     properties={
 *         @OA\Property(property="error", type="string")
 *     }
 * )
 */

class AuthUserRequest extends FormRequest
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
            'email' => ['required', 'email'],
            'password' => ['required', 'min:6']
        ];
    }
}
