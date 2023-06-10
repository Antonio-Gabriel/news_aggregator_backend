<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\PendingRequest;
use App\Services\NewsApiGateway\HasArticle;

class BaseApiService
{
    use HasArticle;

    public PendingRequest $api;

    public function __construct(string $url)
    {
        $this->api = Http::withHeaders([
            'Accept' => 'Application/json',
            'Content-type' => 'Application/json'
        ])->baseUrl($url);
    }
}
