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

        // Apply filters
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('news_source_id')) {
            $query->where('news_source_id', $request->news_source_id);
        }

        if ($request->filled('author_name')) {
            $query->whereHas('author', function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->author_name . '%');
            });
        }

        if ($request->filled('date')) {
            $query->whereDate('published_at', $request->date);
        }

        if ($request->filled('keyword')) {
            $query->where(function ($query) use ($request) {
                $query->where('title', 'like', '%' . $request->keyword . '%')
                      ->orWhere('description', 'like', '%' . $request->keyword . '%')
                      ->orWhere('author', 'like', '%' . $request->keyword . '%');
            });
        }

        if ($request->filled('sort') && $request->input('sort') === 'asc') {
          $query->orderBy('published_at', 'asc');
        } else {
          $query->orderBy('published_at', 'desc');
        }

        return $query;
    }

}
