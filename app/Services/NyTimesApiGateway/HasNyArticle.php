<?php

namespace App\Services\NyTimesApiGateway;

trait HasNyArticle
{
    public function nyArticles(): NyNewsArticles
    {
        return new NyNewsArticles();
    }
}
