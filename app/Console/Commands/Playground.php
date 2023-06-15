<?php

namespace App\Console\Commands;

use App\Domain\Commands\ArticleCommand;
use App\Factories\CreateArticleFactory;
use Illuminate\Console\Command;

class Playground extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'load:external-articles {articles}';

    protected $description = 'Load articles from local database';

    public function handle()
    {
        $categoriesIds = [1, 2, 3, 4, 5, 6];

        $articles = $this->argument('articles');

        $articleFactory = CreateArticleFactory::factory();

        $this->withProgressBar(
            $articles,
            function ($article) use ($articleFactory, $categoriesIds) {
                $randomValues = $categoriesIds[array_rand($categoriesIds)];

                $articleFactory->execute(new ArticleCommand(
                    $article->title,
                    $article->description,
                    $article->source,
                    $article->author,
                    $article->content,
                    $randomValues,
                    $article->url,
                    $article->image_url,
                    $article->publishedAt->format('Y-m-d H:i:s'),
                ));
            }
        );

        $this->info('Articles loaded into database');
    }
}
