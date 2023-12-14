<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\NewsSource;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NewsSourceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        $tables = ['news_sources', 'categories'];
        foreach ($tables as $table) {
            DB::table($table)->truncate();
        }
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        $categories = [
            ['key' => 'general', 'name' => 'General'],
            ['key' => 'technology', 'name' => 'Technology'],
            ['key' => 'business', 'name' => 'Business'],
            ['key' => 'sports', 'name' => 'Sports'],
            ['key' => 'entertainment', 'name' => 'Entertainment'],
        ];

        $sources = [
            [
                'key' => 'abc-news',
                'name' => 'ABC Feed',
            ],
            [
                'key' => 'abc-news-au',
                'name' => 'ABC Feed (AU)',
            ],
            [
                'key' => 'al-jazeera-english',
                'name' => 'Al Jazeera English',
            ],
            [
                'key' => 'ars-technica',
                'name' => 'Ars Technica',
            ],
            [
                'key' => 'associated-press',
                'name' => 'Associated Press',
            ],
            [
                'key' => 'axios',
                'name' => 'Axios',
            ],
            [
                'key' => 'bbc-news',
                'name' => 'BBC Feed',
            ],
            [
                'key' => 'bloomberg',
                'name' => 'Bloomberg',
            ],
            [
                'key' => 'breitbart-news',
                'name' => 'Breitbart Feed',
            ],
            [
                'key' => 'business-insider',
                'name' => 'Business Insider',
            ],
            [
                'key' => 'buzzfeed',
                'name' => 'Buzzfeed',
            ],
            [
                'key' => 'cnbc',
                'name' => 'CNBC',
            ],
            [
                'key' => 'cnn',
                'name' => 'CNN',
            ],
            [
                'key' => 'engadget',
                'name' => 'Engadget',
            ],
            [
                'key' => 'entertainment-weekly',
                'name' => 'Entertainment Weekly',
            ],
            [
                'key' => 'espn',
                'name' => 'ESPN',
            ],
            [
                'key' => 'financial-times',
                'name' => 'Financial Times',
            ],
            [
                'key' => 'google-news',
                'name' => 'Google Feed',
            ],
            [
                'key' => 'hacker-news',
                'name' => 'Hacker Feed',
            ],
            [
                'key' => 'msnbc',
                'name' => 'MSNBC',
            ],
            [
                'key' => 'national-geographic',
                'name' => 'National Geographic',
            ],
            [
                'key' => 'national-review',
                'name' => 'National Review',
            ],
            [
                'key' => 'nbc-news',
                'name' => 'NBC Feed',
            ],
            [
                'key' => 'new-scientist',
                'name' => 'New Scientist',
            ],
            [
                'key' => 'newsweek',
                'name' => 'Newsweek',
            ],
            [
                'key' => 'new-york-magazine',
                'name' => 'New York Magazine',
            ],
            [
                'key' => 'npr',
                'name' => 'NPR',
            ],
            [
                'key' => 'reuters',
                'name' => 'Reuters',
            ],
            [
                'key' => 'techcrunch',
                'name' => 'TechCrunch',
            ],
            [
                'key' => 'techradar',
                'name' => 'TechRadar',
            ],
            [
                'key' => 'the-american-conservative',
                'name' => 'The American Conservative',
            ],
            [
                'key' => 'the-guardian-uk',
                'name' => 'The Guardian (UK)',
            ],
            [
                'key' => 'the-guardian-au',
                'name' => 'The Guardian (AU)',
            ],
            [
                'key' => 'the-hill',
                'name' => 'The Hill',
            ],
            [
                'key' => 'the-hindu',
                'name' => 'The Hindu',
            ],
            [
                'key' => 'the-irish-times',
                'name' => 'The Irish Times',
            ],
            [
                'key' => 'the-new-york-times',
                'name' => 'The New York Times',
            ],
            [
                'key' => 'the-telegraph',
                'name' => 'The Telegraph',
            ],
            [
                'key' => 'the-times-of-india',
                'name' => 'The Times of India',
            ],
            [
                'key' => 'the-verge',
                'name' => 'The Verge',
            ],
            [
                'key' => 'the-wall-street-journal',
                'name' => 'The Wall Street Journal',
            ],
            [
                'key' => 'the-washington-post',
                'name' => 'The Washington Post',
            ],
            [
                'key' => 'the-washington-times',
                'name' => 'The Washington Times',
            ],
            [
                'key' => 'time',
                'name' => 'Time',
            ],
            [
                'key' => 'usa-today',
                'name' => 'USA Today',
            ],
            [
                'key' => 'vice-news',
                'name' => 'Vice Feed',
            ],
            [
                'key' => 'wired',
                'name' => 'Wired',
            ],
        ];


        foreach ($categories as $categoryData) {
            Category::create($categoryData);
        }

        foreach ($sources as $sourceData) {
            NewsSource::create($sourceData);
        }
    }
}
