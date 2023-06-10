<?php

namespace App\Services\NewsApiGateway;

trait HasArticle
{
    public function articles(): NewsArticles
    {
        return new NewsArticles();
    }
}
