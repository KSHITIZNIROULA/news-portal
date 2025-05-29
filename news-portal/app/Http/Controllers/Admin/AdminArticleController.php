<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AdminArticleController extends Controller
{
    public function index()
    {
        $articles = Article::with(['category', 'author'])
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
            'images.*' => 'nullable|image|max:9000',
        ]);

        try {
            $articleData = [
                'title' => $validated['title'],
                'slug' => Str::slug($validated['title']),
                'content' => $validated['content'],
                'category_id' => $validated['category_id'],
                'author_id' => Auth::id(),
                'status' => $validated['status'] ?? 'draft',
                'published_at' => $validated['status'] === 'published'
                    ? ($validated['published_at'] ?? now())
                    : null,
            ];

            if ($request->hasFile('images')) {
                $imagePaths = [];
                foreach ($request->file('images') as $image) {
                    $imagePaths[] = $image->store('articles', 'public');
                }
                $articleData['image'] = $imagePaths;
            }

            $article = Article::create($articleData);

            return redirect()->route('admin.articles.index')
                ->with('success', 'Article created successfully!');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Failed to create article: ' . $e->getMessage());
        }
    }

    public function show(Article $article)
    {
        // Optional: Admins might want to preview the article as it appears publicly
        return redirect()->route('articles.show', $article->slug);
    }

    public function edit(Article $article)
    {
        // Optional: Restrict publishers to their own articles
        if (Auth::user()->hasRole('publisher') && $article->author_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $categories = Category::all();
        return view('admin.articleEdit', compact('article', 'categories'));
    }

    public function update(Request $request, Article $article)
    {
        // Optional: Restrict publishers to their own articles
        if (Auth::user()->hasRole('publisher') && $article->author_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'status' => 'sometimes|in:draft,published',
            'published_at' => 'nullable|date',
            'images.*' => 'nullable|image|max:9000',
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

            // Handle new image uploads
            $imagePaths = $article->image ?? [];
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $imagePaths[] = $image->store('articles', 'public');
                }
            }

            // Handle image removals
            if ($request->input('remove_images')) {
                foreach ($request->input('remove_images') as $imageToRemove) {
                    if ($imageToRemove && in_array($imageToRemove, $imagePaths)) {
                        Storage::disk('public')->delete($imageToRemove);
                        $imagePaths = array_filter($imagePaths, fn($path) => $path !== $imageToRemove);
                    }
                }
                $imagePaths = array_values($imagePaths); // Reindex array
            }

            $articleData['image'] = $imagePaths;

            $article->update($articleData);

            return redirect()->route('admin.articles.index')
                ->with('success', 'Article updated successfully!');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Failed to update article: ' . $e->getMessage());
        }
    }

    public function destroy(Article $article)
    {
        // Optional: Restrict publishers to their own articles
        if (Auth::user()->hasRole('publisher') && $article->author_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        try {
            // Delete associated images
            if ($article->image) {
                foreach ($article->image as $image) {
                    Storage::disk('public')->delete($image);
                }
            }

            $article->delete();

            return redirect()->route('admin.articles.index')
                ->with('success', 'Article deleted successfully!');
        } catch (\Exception $e) {
            return back()
                ->with('error', 'Failed to delete article: ' . $e->getMessage());
        }
    }
}