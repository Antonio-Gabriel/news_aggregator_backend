<?php

namespace App\Services\NewsApiGateway\Entities;

use DateTime;

class Article
{
    public string $title;
    public string $author;
    public ?string $description;
    public ?string $url;
    public ?string $image_url;
    public ?string $source;
    public ?string $content;
    public DateTime $publishedAt;

    public function __construct(array $newsData)
    {
        $this->url = data_get($newsData, "url");
        $this->title = data_get($newsData, "title");
        $this->author = data_get($newsData, "author");
        $this->content = data_get($newsData, "content");
        $this->image_url = data_get($newsData, "urlToImage");
        $this->description = data_get($newsData, "description");
        $this->source = data_get(data_get($newsData, "source"), "name");

        $this->publishedAt = new DateTime(data_get($newsData, "publishedAt"));

        dd([
            "url" => $this->url,
            "title" => $this->title,
            "author" => $this->author,
            "source" => $this->source,
            "content" => $this->content,
            "image_url" => $this->image_url,
            "description" => $this->description,
            "publishedAt" => $this->publishedAt,
        ]);
    }
}
