<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class NewsApiScrapper extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:news-api-scraper';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';


    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        return Command::SUCCESS;
    }
}
