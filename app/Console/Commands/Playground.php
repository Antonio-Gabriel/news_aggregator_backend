<?php

namespace App\Console\Commands;

use App\Services\NewsApiGateway\NewsArticles;
use Illuminate\Console\Command;

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
        $articles = new NewsArticles();
        $data = $articles->get();

        dd($data);
    }
}
