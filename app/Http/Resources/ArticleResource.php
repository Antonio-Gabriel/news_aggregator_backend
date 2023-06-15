<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class ArticleResource
 * @package App\Http\Resources
 * @OA\Schema(
 *     schema="ArticleResource",
 *     type="object",
 *     title="Article response",
 *     properties={
 *         @OA\Property(property="id", type="integer"),
 *         @OA\Property(property="title", type="string"),
 *         @OA\Property(property="description", type="string"),
 *         @OA\Property(property="source", type="string"),
 *         @OA\Property(property="author", type="string"),
 *         @OA\Property(property="content", type="string"),
 *         @OA\Property(property="url", type="string"),
 *         @OA\Property(property="url_image", type="string"),
 *         @OA\Property(property="published_at", type="string"),
 *         @OA\Property(property="category", type="object", properties={
 *             @OA\Property(property="id", type="integer"),
 *             @OA\Property(property="name", type="string"),
 *             @OA\Property(property="createdAt", type="string"),
 *         })
 *     }
 * )
 * @OA\Schema(
 *     schema="ArticleResourceValidationError",
 *     type="object",
 *     title="Create/Update ArticleResourceValidationError",
 *     properties={
 *         @OA\Property(property="errors", type="object", properties={
 *             @OA\Property(property="title", type="array", @OA\Items(type="string")),
 *             @OA\Property(property="description", type="array", @OA\Items(type="string")),
 *             @OA\Property(property="source", type="array", @OA\Items(type="string")),
 *             @OA\Property(property="author", type="array", @OA\Items(type="string")),
 *             @OA\Property(property="content", type="array", @OA\Items(type="string")),
 *             @OA\Property(property="url", type="array", @OA\Items(type="string")),
 *             @OA\Property(property="url_image", type="array", @OA\Items(type="string")),
 *             @OA\Property(property="category_id", type="array", @OA\Items(type="integer")),
 *             @OA\Property(property="published_at", type="array", @OA\Items(type="string"))
 *         })
 *     }
 * )
 */
class ArticleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'source' => $this->source,
            'author' => $this->author,
            'content' => $this->content,
            'url' => $this->url,
            'url_image' => $this->url_image,
            'published_at' => $this->published_at,
            'category' => new CategoryResource($this->category)
        ];
    }
}
