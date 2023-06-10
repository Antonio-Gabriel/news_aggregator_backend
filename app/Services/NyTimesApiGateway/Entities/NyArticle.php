<?php

namespace App\Services\NyTimesApiGateway\Entities;

use DateTime;

class NyArticle
{
    public string $title;
    public ?string $author;
    public ?string $description;
    public ?string $url;
    public ?string $image_url;
    public ?string $source;
    public ?string $content;
    public DateTime $publishedAt;

    public function __construct(array $newsData)
    {
        $this->content = null;
        $this->url = data_get($newsData, "web_url");
        $this->source = data_get($newsData, "source");
        $this->description = data_get($newsData, "lead_paragraph");
        $this->title = data_get(data_get($newsData, "headline"), "main");
        $this->author = data_get(data_get($newsData, "byline"), "original");

        if (count(data_get($newsData, "multimedia")) > 0) {
            $this->image_url = data_get(data_get($newsData, "multimedia")[0], "url");
        }

        $this->publishedAt = new DateTime(data_get($newsData, "pub_date"));
    }
}
