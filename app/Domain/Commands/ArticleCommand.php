<?php

namespace App\Domain\Commands;

class ArticleCommand
{
    public function __construct(
        public string $title,
        public ?string $description,
        public ?string $source,
        public ?string $author,
        public int $category_id,
        public ?string $url,
        public ?string $url_image,
        public string $published_at
    ) {
    }
}
