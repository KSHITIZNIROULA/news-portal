<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('home', [
            'articles' => Article::where('status', 'published')
                ->with(['category', 'author', 'images'])
                ->latest('published_at')
                ->take(9)
                ->get(),
            'trendingCategories' => Category::withCount('articles')
                ->orderBy('articles_count', 'desc')
                ->take(4)
                ->get(),
            'breaking'=>Article::where('status', 'published')
                ->with(['category', 'author', 'images'])
                ->latest('published_at')
                ->take(1)
                ->get(),
        ]);
    }
}
