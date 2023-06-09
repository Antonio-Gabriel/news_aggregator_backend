<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SyncExternalNewsAggregate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:external-news-aggregate';

    protected $description = 'Get external news and insert from our database';

    public function handle()
    {
        $this->withProgressBar(100, fn () => sleep(1));
    }
}
