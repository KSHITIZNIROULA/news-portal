<!-- resources/views/articles/index.blade.php -->
@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-6">
        <h1 class="text-3xl font-bold mb-6 text-gray-800">News Articles</h1>

        @if($articles->isEmpty())
            <p class="text-center text-gray-500 text-lg">No articles available at the moment.</p>
        @else
            <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                @foreach($articles as $article)
                    <div class="bg-white border rounded-lg shadow-md p-4 hover:shadow-lg transition-shadow">
                        <h2 class="text-xl font-semibold mb-2">
                            <a href="{{ route('articles.show', $article->slug) }}" class="text-blue-600 hover:underline">
                                {{ $article->title }}
                            </a>
                        </h2>
                        <p class="text-gray-600 text-sm mb-2">
                            By {{ $article->author->name }} in {{ $article->category->name }} | 
                            {{ $article->published_at->format('M d, Y') }}
                        </p>
                        @if($article->image && count($article->image) > 0)
                            <div class="mb-3">
                                <img src="{{ asset('storage/' . $article->image[0]) }}" alt="{{ $article->title }}" class="w-full h-48 object-cover rounded">
                            </div>
                        @endif
                        <p class="text-gray-700">
                            {{ Str::limit(strip_tags($article->content), 150) }}
                            <a href="{{ route('articles.show', $article->slug) }}" class="text-blue-500 hover:underline">Read more</a>
                        </p>
                    </div>
                @endforeach
            </div>
            <div class="mt-6">
                {{ $articles->links() }}
            </div>
        @endif
    </div>
@endsection