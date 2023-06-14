<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArticleRequest extends FormRequest
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
            'title' => ['min:6'],
            'description' => ['min:6'],
            'source' => ['min:6'],
            'author' => ['min:6'],
            'url' => ['url'],
            'url_image' => ['url'],
            'published_at' => ['date'],
            'category_id' => ['integer']
        ];
    }
}
