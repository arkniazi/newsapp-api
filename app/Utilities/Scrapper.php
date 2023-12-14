<?php

namespace App\Utilities;

use App\Models\Article;
use App\Models\Category;
use App\Models\NewsSource;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Symfony\Component\DomCrawler\Crawler;

class Scrapper
{
  public function fetchData($url, $params)
  {
    return Http::get($url, $params);
  }

  public function determineCategory($article, $defaultCategoryId, $defaultCategoryKey)
  {
    $category_key = $article[$defaultCategoryKey];
    $article_category = Category::where('key', 'like', "%$category_key%")->first();
    return $article_category ? $article_category->id : $defaultCategoryId;
  }


  public function getSource($sourceName)
  {
    $sourceKey = strtolower(str_replace(' ', '_', $sourceName));
    return NewsSource::firstOrCreate(['name' => $sourceName], ['key' => $sourceKey]);
  }

  public function storeNewsArticle($articleData)
  {
    return Article::create($articleData);
  }

  public function logScrapedData($scrapedData)
  {
    Log::info("Scraped Data", ['data' => $scrapedData]);
  }

  public function getFullArticleContent($url)
  {
    try {
      $response = Http::get($url);

      if ($response->successful()) {
        $crawler = new Crawler($response->body());
        $paragraphs = $crawler->filter('p')->each(function (Crawler $node) {
          return $node->text();
        });

        return implode("\n", $paragraphs);
      }
    } catch (\Exception $e) {
      Log::error('Error fetching content for URL ' . $url . ': ' . $e->getMessage());
    }

    return null;
  }

}
