<?php

namespace App\Services\NewsApiGateway;

use App\Services\BaseEndpoint;
use App\Services\BaseApiService;
use Illuminate\Support\Collection;
use App\Services\NewsApiGateway\Entities\Article;

class NewsArticles extends BaseEndpoint
{
    public function __construct()
    {
        parent::__construct(
            new BaseApiService(
                url: 'https://newsapi.org/v2/'
            )
        );
    }

    public function get(): Collection
    {
        $key = config('services.external_services.newsapi_key');
        return $this->transform(
            $this->service->api
                ->get("everything?q=*&apiKey={$key}")
                ->json('articles'),
            Article::class
        );
    }
}
