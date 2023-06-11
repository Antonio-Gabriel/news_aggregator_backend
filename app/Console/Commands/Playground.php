<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\NyTimesApiGateway\NyNewsArticles;

class Playground extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'load:external-articles';

    protected $description = 'Command description';

    public function handle()
    {
        // $articles = new NewsArticles();
        // $data = $articles->get();

        // dd($data);

        $nyNewsArticlesService = new NyNewsArticles();
        $data = $nyNewsArticlesService->get();

        dd($data);
    }
}
