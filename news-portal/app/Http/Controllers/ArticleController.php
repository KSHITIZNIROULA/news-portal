<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Services\Fake;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $categoryId = $request->query('category');
        $articles = Article::where('status', 'published')
            ->when($categoryId, function ($query) use ($categoryId) {
                return $query->where('category_id', $categoryId);
            })
            ->with(['category', 'author', 'images'])
            ->orderBy('published_at', 'desc')
            ->paginate(9);

        $Latestarticles = Article::where('status', 'published')
            ->whereNotIn('id', $articles->pluck('id'))
            ->latest('published_at')
            ->limit(3)
            ->get();
        return view('article.index', compact('articles', 'Latestarticles'));
    }


    public function show(string $slug)
    {
        $article = Article::where('slug', $slug)
            ->where('status', 'published')
            ->with(['category', 'author'])
            ->firstOrFail();

        return view('article.show', ['article' => $article]);
    }

    public function search(Request $request)
    {
        $query = $request->input('q');

        $articles = Article::where('status', 'published')
            ->when($query, function ($queryBuilder) use ($query) {
                return $queryBuilder->where('title', 'like', "%{$query}%")
                    ->orWhere('content', 'like', "%{$query}%")
                    ->orWhereHas('category', function ($q) use ($query) {
                        $q->where('name', 'like', "%{$query}%");
                    })
                    ->orWhereHas('author', function ($q) use ($query) {
                        $q->where('name', 'like', "%{$query}%");
                    });
            })
            ->with(['category', 'author', 'images'])
            ->orderBy('published_at', 'desc')
            ->paginate(9);
        $articles->appends(['q' => $query]);
        return view('article.search', compact('articles', 'query'));
    }

    public function forYou()
    {
        $articles = Article::where('status', 'published')
            ->with(['category', 'author', 'images'])
            ->orderBy('published_at', 'desc')
            ->paginate(6);
        return view('article.foryou', compact('articles'));
    }

    public function fake()
    {
        $articles = Article::with(['category', 'author', 'images'])->paginate(6);
        return view('admin.fake', compact('articles'));
    }

    public function analyze(Article $article)
    {
        $detector = new Fake();
        $analysis = $detector->analyzeArticle($article);

        // Update the article with truth score (100 - fake score)
        $article->update([
            'truth_score' => 100 - min($analysis['score'], 100)
        ]);

        return response()->json([
            'truth_score' => $article->truth_score,
            'reasons' => $analysis['reasons'],
            'article_id' => $article->id,
        ]);
    }
}
