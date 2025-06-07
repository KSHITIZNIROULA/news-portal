<?php

namespace App\Http\Controllers;

use App\Models\Article;
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
        ->when($categoryId, function ($query) use ($categoryId) {
            return $query->where('category_id', $categoryId);
        })
        ->with(['category', 'author', 'images'])
        ->orderBy('published_at', 'asc')
        ->paginate(9);
    return view('article.index', compact('articles','Latestarticles'));
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
        return view('article.search', compact('articles','query'));
    }
}
