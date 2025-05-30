<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
{
        $articles = Article::where('status', 'published')
            ->with(['category', 'author'])
            ->latest('published_at')
            ->paginate(10);

        return view('article.index',['articles' => $articles]);
    }


public function show(string $slug)
    {
        $article = Article::where('slug', $slug)
            ->where('status', 'published')
            ->with(['category', 'author'])
            ->firstOrFail();

        return view('article.show',['article' => $article]);
    }

}
