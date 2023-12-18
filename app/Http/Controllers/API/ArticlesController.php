<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\ArticleResource;
use App\Models\Article;
use App\Models\Category;
use App\Models\NewsSource;
use App\Repositories\ArticleRepository;
use Illuminate\Http\Request;

class ArticlesController extends Controller
{

    protected $articleRepository;

    public function __construct(ArticleRepository $articleRepository)
    {
        $this->articleRepository = $articleRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return [ArticleResource]
     */
    public function index(Request $request)
    {
        $query = $this->articleRepository->getFilteredArticles($request);
        $articles = $query->paginate(10);
        return ArticleResource::collection($articles);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return ArticleResource
     */
    public function show(Article $article)
    {
        return new ArticleResource($article);
    }

    public function getArticlesMeta(Request $request)
    {
        if ($request->has('type')) {
            $categories = Category::all();
            $sources = NewsSource::all();
            $authors = Article::withoutGlobalScope('user_preferences')->whereNotNull('author')->distinct()->pluck('author');
        } else {
            $categories = Category::has('news')->get();
            $sources = NewsSource::has('news')->get();
            $authors = Article::whereNotNull('author')->distinct()->pluck('author');
        }

        return response()->json([
            'categories' => $categories,
            'sources' => $sources,
            'authors' => $authors
        ]);
    }

}
