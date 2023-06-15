<?php

namespace App\Console\Commands;

use App\Services\NewsApiGateway\NewsArticles;
use App\Services\NyTimesApiGateway\NyNewsArticles;
use Illuminate\Console\Command;

class SyncExternalNewsAggregate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:external-news';

    protected $description = 'Get external news and insert from our database';

    public function handle()
    {
        $externalArticles = [];

        $articlesService = new NewsArticles();
        $data = $articlesService->get();
        array_push($externalArticles, ...$data);

        $nyNewsArticlesService = new NyNewsArticles();
        $data = $nyNewsArticlesService->get();
        array_push($externalArticles, ...$data);

        $this->call('load:external-articles', [
            'articles' => $externalArticles
        ]);
    }
}
