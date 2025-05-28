<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class AdminArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function createUser()
    {
        return view('admin.users.create');
    }

    public function storeuser(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user->assignRole($request->role);

        return redirect()->route('admin.articles.index')->with('success', 'User created successfully.');
    }

    public function index()
    {
        $articles = Article::with(['category', 'author'])->paginate(10);
        return view('admin.articleIndex', ['articles' => $articles]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories=Category::all();
        return view('article.create',compact('categories'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'status' => 'sometimes|in:draft,published',
            'published_at' => 'nullable|date',
            'images.*'=>'nullable|image|max:9000',
        ]);

        try {
            $article = Article::create([
                'title' => $validated['title'],
                'slug' => Str::slug($validated['title']),
                'content' => $validated['content'],
                'category_id' => $validated['category_id'],
                'author_id' => auth()->id(), // Automatically set logged-in user as author
                'status' => $validated['status'] ?? 'draft',
                'published_at' => $validated['status'] === 'published'
                    ? ($validated['published_at'] ?? now())
                    : null,
            ]);
            if($request->hasFile('images')){
                $imagePaths=[];
                foreach($request->file('images') as $image){
                    $imagePaths[]=$image->store('articles','public');
                }
                $articleData['image']=$imagePaths;
            }

            return redirect()->route('admin.articles.index', $article)
                ->with('success', 'Article created successfully!');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Failed to create article: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Article $article)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Article $article)
    {
        $categories= Category::all();
        return view('admin.articleEdit',compact('article','categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Article $article)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article)
    {
        //
    }
}
