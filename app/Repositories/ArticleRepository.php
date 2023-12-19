<?php

namespace App\Repositories;

use App\Models\Article;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class ArticleRepository
{
    public function getFilteredArticles(Request $request): Builder
    {
        $query = Article::query();

        $query->when($request->filled('category_id'), function ($query) use ($request) {
            $query->where('category_id', $request->category_id);
        });

        $query->when($request->filled('source_id'), function ($query) use ($request) {
            $query->where('news_source_id', $request->source_id);
        });

        $query->when($request->filled('author_name'), function ($query) use ($request) {
            $query->where('author', 'like', '%' . $request->author_name . '%');
        });

        $query->when($request->filled('date'), function ($query) use ($request) {
            $query->whereDate('published_at', $request->date);
        });

        $query->when($request->filled('keyword'), function ($query) use ($request) {
            $query->where(function ($query) use ($request) {
                $query->where('title', 'like', '%' . $request->keyword . '%');
            });
        });

        $query->when($request->filled('sort') && $request->input('sort') === 'asc', function ($query) {
            $query->orderBy('published_at', 'asc');
        }, function ($query) {
            $query->orderBy('published_at', 'desc');
        });


        return $query;
    }

}
