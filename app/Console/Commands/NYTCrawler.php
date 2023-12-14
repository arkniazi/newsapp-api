<?php

namespace App\Console\Commands;

use App\Models\Article;
use App\Models\Category;
use App\Utilities\Scrapper;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class NYTCrawler extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:nyt-crawler';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    protected $scrapper;


    public function __construct()
    {
        parent::__construct();
        $this->scrapper = new Scrapper();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Scraping from the News API...');

        // Make an API request to retrieve news data

        $url = env('NEWYORK_TIMES_API_URL');
        $params =  [
            'limit' => 50,
            'api-key' => env('NEWYORK_TIMES_API_KEY'),
        ];

        $response = $this->scrapper->fetchData($url, $params);
        if (!$response->successful()) {
            $this->error("Failed to fetch data}");
        }

        $data = $response->json();
        $results = $data['results'];
        $filteredData = $this->filterAndStoreData($results);

        $this->scrapper->logScrapedData($filteredData);
        $this->info('Scraping complete.');
    }

    private function filterAndStoreData($articles)
    {
        $filteredData = [];
        $source = $this->scrapper->getSource('The New York Times');
        $general_category_id = Category::where('key', 'general')->first()->id;

        foreach ($articles as $article) {
            $category_id = $this->scrapper->determineCategory($article, $general_category_id, 'subsection');
            $existingNews = $this->checkExistingNews($article);

            if (!$existingNews && $this->isValidArticle($article)) {
                $articleData = $this->prepareArticleData($article, $source->id, $category_id);
                if ($articleData) {
                    $this->scrapper->storeNewsArticle($articleData);
                }
                $filteredData[] = $articleData;
            }
        }

        return $filteredData;
    }

    private function checkExistingNews($article)
    {
        return Article::withoutGlobalScope('user_preferences')->where('source_url', $article['url'] ?? '')->first();
    }

    private function isValidArticle($article)
    {
        return !is_null(!is_null($article['title']) && !is_null($article['url']));
    }

    private function prepareArticleData($article, $sourceId, $categoryId)
    {
        
        $thumbnail_url = array_reduce($article['multimedia'], function ($carry, $item) {
            return $carry ?: ($item['format'] === 'mediumThreeByTwo440' ? $item['url'] : null);
        });
        if (preg_match('/By\s+(.+)/', $article['byline'], $matches)) {
            $authorName = $matches[1];
        } else {
            $authorName = $article['byline'];
        }
        return [
            'title' => $article['title'],
            'slug' => Str::limit($article['abstract'], 255),
            'category_id' => $categoryId,
            'news_source_id' => $sourceId,
            'source_url' => $article['url'],
            'author' => $authorName,
            'description' => null,
            'published_at' => date('Y-m-d H:i:s', strtotime($article['published_date'])),
            'thumbnail_url' => $thumbnail_url,
        ];
    
    }

}
