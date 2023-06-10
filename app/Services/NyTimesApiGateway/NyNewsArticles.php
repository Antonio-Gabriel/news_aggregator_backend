<?php

namespace App\Services\NyTimesApiGateway;

use App\Services\BaseApiService;
use App\Services\BaseEndpoint;
use App\Services\NyTimesApiGateway\Entities\NyArticle;
use Illuminate\Support\Collection;

class NyNewsArticles extends BaseEndpoint
{
    public function __construct()
    {
        parent::__construct(
            new BaseApiService(
                url: 'https://api.nytimes.com/'
            )
        );
    }

    public function get(): Collection
    {
        $key = config('services.external_services.nytimes_key');
        return $this->transform(
            $this->service->api
                ->get("svc/search/v2/articlesearch.json?api-key={$key}")
                ->json('response')['docs'],
            NyArticle::class
        );
    }
}
