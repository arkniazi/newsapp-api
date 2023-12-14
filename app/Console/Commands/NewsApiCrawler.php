<?php

namespace App\Console\Commands;

use App\Models\Article;
use App\Models\Category;
use App\Utilities\Scrapper;
use Illuminate\Console\Command;
use Illuminate\Support\Str;


class NewsApiCrawler extends Command
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
        $this->info('Scraping Feed data...');

        $url = env('NEWS_API_URL');
        

        // Make an API request to retrieve news data
        $categories = Category::all();

        $scrapedData = [];

        foreach ($categories as $category) {
            $params = [
                'country' => 'us',
                'language' => 'en',
                'apiKey' => env('NEWS_API_KEY'),
                'category' => $category->key,
                'pageSize' => 100,
            ];
            $response = $this->scrapper->fetchData($url, $params);
            if (!$response->successful()) {
                $this->error("Failed to fetch data for the category: {$category->key}");
                continue;
            }

            $data = $response->json();
            $filteredData = $this->filterAndStoreData($data['articles'], $category->id);
            $scrapedData = array_merge($scrapedData, $filteredData);
        }

        $this->scrapper->logScrapedData($scrapedData);
        $this->info('Scraping complete');
    }

    private function filterAndStoreData($articles, $category_id)
    {
        $filteredData = [];

        foreach ($articles as $article) {
            $source = $this->scrapper->getSource($article['source']['name']);
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
        return Article::withoutGlobalScope('user_preferences')->where('slug', $article['description'])->first();
    }

    private function isValidArticle($article)
    {
        return !is_null($article['title']) && !is_null($article['description']) && !is_null($article['content']) && !is_null($article['urlToImage']);
    }

    private function prepareArticleData($article, $sourceId, $categoryId)
    {
        $news_content = $this->scrapper->getFullArticleContent($article['url']);
        if ($news_content) {
            return [
                'title' => $article['title'],
                'slug' => Str::limit($article['description'], 255),
                'category_id' => $categoryId,
                'news_source_id' => $sourceId,
                'source_url' => $article['url'],
                'author' => $article['author'],
                'description' => $news_content,
                'published_at' => date('Y-m-d H:i:s', strtotime($article['publishedAt'])),
                'thumbnail_url' => $article['urlToImage'],
            ];
        }
        return null;
    }
}
