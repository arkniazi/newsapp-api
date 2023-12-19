<?php

namespace App\Console\Commands;

use App\Models\Article;
use App\Models\Category;
use App\Utilities\Scrapper;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class GaurdianCrawler extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:gaurdian-crawler';

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

        $url = env('GUARDIAN_API_URL');
        $params = [
            'page-size' => 100,
            'api-key' => env('GUARDIAN_API_KEY'),
        ];

        $response = $this->scrapper->fetchData($url, $params);
        if (!$response->successful()) {
            $this->error("Failed to fetch data}");
        }

        $data = $response->json();
        $results = $data['response']['results'];
        $filteredData = $this->filterAndStoreData($results);

        $this->scrapper->logScrapedData($filteredData);
        $this->info('Scraping complete.');
    }

    private function filterAndStoreData($articles)
    {
        $filteredData = [];
        $source = $this->scrapper->getSource('The Guardian');
        $general_category_id = Category::where('key', 'general')->first()->id;

        foreach ($articles as $article) {
            $category_id = $this->scrapper->determineCategory($article, $general_category_id, 'sectionId');
            $existingNews = $this->checkExistingNews($article);

            if (!$existingNews && $this->isValidArticle($article)) {
                $articleData = $this->prepareArticleData($article, $source->id, $category_id);
                if($articleData){
                    $this->scrapper->storeNewsArticle($articleData);
                }
                $filteredData[] = $articleData;
            }
        }

        return $filteredData;
    }

    private function checkExistingNews($article)
    {
        return Article::withoutGlobalScope('user_preferences')->where('source_url', $article['webUrl'] ?? '')->first();
    }

    private function isValidArticle($article)
    {
        return !is_null($article['webTitle']) && !is_null($article['webUrl']);
    }

    private function prepareArticleData($article, $sourceId, $categoryId)
    {
        $news_content = $this->scrapper->getFullArticleContent($article['webUrl']);
        if ($news_content) {
            return [
                'title' => $article['webTitle'],
                'slug' => Str::limit($news_content, 255),
                'category_id' => $categoryId,
                'news_source_id' => $sourceId,
                'source_url' => $article['webUrl'],
                'author' => null,
                'description' => $news_content,
                'published_at' => date('Y-m-d H:i:s', strtotime($article['webPublicationDate'])),
                'thumbnail_url' => null,
            ];
        }
        return null;
    }
}

