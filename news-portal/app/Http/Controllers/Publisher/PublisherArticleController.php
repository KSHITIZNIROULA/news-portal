<?php

namespace App\Http\Controllers\Publisher;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class PublisherArticleController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:publisher|admin']);
    }

    public function dashboard()
    {
        $articles = Article::where('author_id', Auth::id())
            ->with(['category', 'images'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        $totalArticles = Article::where('author_id', Auth::id())->count();
        $publishedArticles = Article::where('author_id', Auth::id())->where('status', 'published')->count();
        $exclusiveArticles = Article::where('author_id', Auth::id())->where('is_exclusive', true)->count();

        return view('publisher.dashboard', compact('articles', 'totalArticles', 'publishedArticles', 'exclusiveArticles'));
    }
    

    public function create()
    {
        $categories = Category::select('id', 'name')->get();
        return view('publisher.articleCreate', compact('categories'));
    }

    public function store(Request $request)
    {
        $this->authorize('publish exclusive articles'); // Spatie permission check

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category_id' => 'nullable|exists:categories,id',
            'status' => 'required|in:draft,published',
            'is_exclusive' => 'boolean',
            'images.*' => 'nullable|image|mimes:jpeg,png|max:5120', // 5MB per image
            'published_at' => [
                'nullable',
                'date',
                function ($attribute, $value, $fail) use ($request) {
                    if ($request->status === 'published' && $value && now()->gt($value)) {
                        $fail('The publish date must be now or a future date.');
                    }
                },
            ],
        ]);

        try {
            // Generate unique slug
            $baseSlug = Str::slug($validated['title']);
            $slug = $baseSlug;
            $count = 1;
            while (Article::where('slug', $slug)->exists()) {
                $slug = $baseSlug . '-' . $count++;
            }

            $article = Article::create([
                'title' => $validated['title'],
                'slug' => $slug,
                'content' => $validated['content'],
                'category_id' => $validated['category_id'],
                'author_id' => Auth::id(),
                'status' => $validated['status'],
                'is_exclusive' => $request->has('is_exclusive'),
                'published_at' => $validated['status'] === 'published' ? ($validated['published_at'] ?? now()) : null,
            ]);

            $images=($request->file('images',[]));
                // $images = $request->file('images');
                if(is_array($images) && count($images)>0){
                if (count($images) > 3) {
                    return back()->withInput()->with('error', 'You can upload a maximum of 3 images.');
                }

                foreach ($images as $image) {
                    if ($image->isValid()) {
                        $path = $image->store('articles', 'public');
                        $article->images()->create(['path' => $path]);
                    }
                }
            }

            // dd($article);
            return redirect()->route('publisher.articles.dashboard')
                ->with('success', 'Article created successfully!');
        } catch (\Exception $e) {
            Log::error('Failed to create article: ' . $e->getMessage(), ['user_id' => Auth::id()]);
            return back()->withInput()->with('error', 'Failed to create article. Please try again.');
        }
    }

    public function show(Article $article)
    {
        if ($article->author_id !== Auth::id() && !Auth::user()->hasRole('admin')) {
            abort(403, 'Unauthorized action.');
        }
        return view('publisher.articleShow', compact('article'));
    }

    public function edit(Article $article)
    {
        if ($article->author_id !== Auth::id() && !Auth::user()->hasRole('admin')) {
            abort(403, 'Unauthorized action.');
        }

        $categories = Category::select('id', 'name')->get();
        return view('publisher.articleEdit', compact('article', 'categories'));
    }

    public function update(Request $request, Article $article)
    {
        // Authorization check
        if ($article->author_id !== Auth::id() && !Auth::user()->hasRole('admin')) {
            abort(403, 'Unauthorized action.');
        }

        // Only check permission if updating to exclusive
        if ($request->boolean('is_exclusive')) {
            $this->authorize('publish exclusive articles');
        }

        // Validate request
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category_id' => 'nullable|exists:categories,id',
            'status' => 'required|in:draft,published',
            'published_at' => 'nullable|date|after_or_equal:now',
            'is_exclusive' => 'boolean',
            'images.*' => 'nullable|image|mimes:jpeg,png|max:5120',
            'remove_images' => 'nullable|array',
            'remove_images.*' => 'string|exists:images,path',
        ]);

        try {
            // Update slug only if title changed
            if ($article->title !== $validated['title']) {
                $baseSlug = Str::slug($validated['title']);
                $slug = $baseSlug;
                $count = 1;
                while (Article::where('slug', $slug)->where('id', '!=', $article->id)->exists()) {
                    $slug = $baseSlug . '-' . $count++;
                }
                $validated['slug'] = $slug;
            }

            // Handle published_at date
            $validated['published_at'] = $validated['status'] === 'published'
                ? ($validated['published_at'] ?? now())
                : null;

            // Update article
            $article->update($validated);

            // Handle image removals first
            if ($request->filled('remove_images')) {
                foreach ($request->remove_images as $imagePath) {
                    $image = $article->images()->where('path', $imagePath)->first();
                    if ($image) {
                        Storage::disk('public')->delete($image->path);
                        $image->delete();
                    }
                }
            }

            // Handle new image uploads
            if ($request->hasFile('images')) {
                $remainingSlots = 3 - $article->images()->count();
                if (count($request->images) > $remainingSlots) {
                    return back()->withInput()->with('error', 'You can only upload ' . $remainingSlots . ' more images.');
                }

                foreach ($request->images as $image) {
                    if ($image->isValid()) {
                        $path = $image->store('articles', 'public');
                        $article->images()->create(['path' => $path]);
                    }
                }
            }

            return redirect()->route('publisher.articles.dashboard')
                ->with('success', 'Article updated successfully!');
        } catch (\Exception $e) {
            Log::error('Failed to update article: ' . $e->getMessage(), [
                'user_id' => Auth::id(),
                'article_id' => $article->id,
                'request_data' => $request->except(['images', '_token']),
            ]);
            return back()->withInput()->with('error', 'Failed to update article. Please try again.');
        }
    }

    public function destroy(Article $article)
    {
        if ($article->author_id !== Auth::id() && !Auth::user()->hasRole('admin')) {
            abort(403, 'Unauthorized action.');
        }

        try {
            foreach ($article->images as $image) {
                Storage::disk('public')->delete($image->path);
                $image->delete();
            }

            $article->delete();

            return redirect()->route('publisher.articles.dashboard')
                ->with('success', 'Article deleted successfully!');
        } catch (\Exception $e) {
            Log::error('Failed to delete article: ' . $e->getMessage(), ['user_id' => Auth::id(), 'article_id' => $article->id]);
            return back()->with('error', 'Failed to delete article. Please try again.');
        }
    }
}
