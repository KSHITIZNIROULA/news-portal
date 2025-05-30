<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class AdminArticleController extends Controller
{
    public function index()
    {
        $articles = Article::with(['category', 'author', 'images'])
            ->when(Auth::user()->hasRole('publisher'), function ($query) {
                $query->where('author_id', Auth::id());
            })
            ->paginate(10);
        return view('admin.articleIndex', compact('articles'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.articleCreate', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'status' => 'sometimes|in:draft,published',
            'published_at' => 'nullable|date',
            'images.*' => 'nullable|image|max:2048', // Reduced to 2MB for testing
        ]);

        try {
 // Generate unique slug
        $slug = Str::slug($validated['title']);
        $originalSlug = $slug;
        $count = 1;
        
        while (Article::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count++;
        }
            $articleData = [
                'title' => $validated['title'],
                'slug' => $slug,
                'content' => $validated['content'],
                'category_id' => $validated['category_id'],
                'author_id' => Auth::id(),
                'status' => $validated['status'] ?? 'draft',
                'published_at' => $validated['status'] === 'published'
                    ? ($validated['published_at'] ?? now())
                    : null,
            ];

            $article = Article::create($articleData);

            $request->hasFile('images');
                foreach ($request->file('images') as $image) {
                        $path = $image->store('articles', 'public');
                        $article->images()->create(['path' => $path]);
                }

            return redirect()->route('admin.articles.index')
                ->with('success', 'Article created successfully!');
        } catch (\Exception $e) {
            Log::error('Failed to create article:', ['error' => $e->getMessage()]);
            return back()
                ->withInput()
                ->with('error', 'Failed to create article: ' . $e->getMessage());
        }
    }

    public function show(Article $article)
    {
        return redirect()->route('articles.show', $article->slug);
    }

    public function edit(Article $article)
    {
        if (Auth::user()->hasRole('publisher') && $article->author_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $categories = Category::all();
        return view('admin.articleEdit', compact('article', 'categories'));
    }

    public function update(Request $request, Article $article)
    {
        if (Auth::user()->hasRole('publisher') && $article->author_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'status' => 'sometimes|in:draft,published',
            'published_at' => 'nullable|date',
            'images.*' => 'nullable|image|max:2048',
        ]);

        try {
            $articleData = [
                'title' => $validated['title'],
                'slug' => Str::slug($validated['title']),
                'content' => $validated['content'],
                'category_id' => $validated['category_id'],
                'status' => $validated['status'] ?? 'draft',
                'published_at' => $validated['status'] === 'published'
                    ? ($validated['published_at'] ?? now())
                    : null,
            ];

            $article->update($articleData);

            // Handle new image uploads
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    if ($image->isValid()) {
                        $path = $image->store('articles', 'public');
                        $article->images()->create(['path' => $path]);
                    }
                }
            }

            // Handle image removals
            if ($request->input('remove_images')) {
                foreach ($request->input('remove_images') as $imagePath) {
                    $image = $article->images()->where('path', $imagePath)->first();
                    if ($image) {
                        Storage::disk('public')->delete($imagePath);
                        $image->delete();
                    }
                }
            }

            return redirect()->route('admin.articles.index')
                ->with('success', 'Article updated successfully!');
        } catch (\Exception $e) {
            Log::error('Failed to update article:', ['error' => $e->getMessage()]);
            return back()
                ->withInput()
                ->with('error', 'Failed to update article: ' . $e->getMessage());
        }
    }

    public function destroy(Article $article)
    {
        if (Auth::user()->hasRole('publisher') && $article->author_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        try {
            // Delete associated images
            foreach ($article->images as $image) {
                Storage::disk('public')->delete($image->path);
            }

            $article->delete();

            return redirect()->route('admin.articles.index')
                ->with('success', 'Article deleted successfully!');
        } catch (\Exception $e) {
            Log::error('Failed to delete article:', ['error' => $e->getMessage()]);
            return back()
                ->with('error', 'Failed to delete article: ' . $e->getMessage());
        }
    }
}