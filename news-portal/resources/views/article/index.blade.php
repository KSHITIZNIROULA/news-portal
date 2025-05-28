<!-- resources/views/articles/index.blade.php -->
@extends('layouts.app') <!-- Changed from 'admin.dashboard' to 'layouts.app' -->

@section('content')
    <div class="container mx-auto pt-2 px-2">
        <h1 class="text-2xl font-bold mb-4 text-gray-900 border-b border-gray-200 pb-2">Latest News</h1>
        @if($articles->isEmpty())
            <p class="text-center text-gray-500 text-sm py-4">No articles available at the moment.</p>
        @else
            <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-3">
                @foreach($articles as $article)
                    <div class="bg-white border rounded-lg shadow-sm hover:shadow-md transition-shadow overflow-hidden">
                        <a href="{{ route('articles.show', $article->slug) }}" class="block">
                            @if($article->image && count($article->image) > 0)
                                <div class="w-full h-40">
                                    <img src="{{ asset('storage/' . $article->image[0]) }}" alt="{{ $article->title }}" class="w-full h-full object-cover">
                                </div>
                            @else
                                <div class="w-full h-40 bg-gray-200 flex items-center justify-center">
                                    <span class="text-gray-400 text-sm">No Image</span>
                                </div>
                            @endif
                        </a>
                        <div class="p-3">
                            <div class="flex items-center mb-2">
                                <span class="inline-block bg-blue-100 text-blue-800 text-xs font-semibold px-2 py-0.5 rounded">{{ $article->category->name }}</span>
                                <span class="text-gray-500 text-xs ml-2">{{ $article->published_at->format('M d, Y') }}</span>
                            </div>
                            <h2 class="text-lg font-semibold mb-1 leading-tight">
                                <a href="{{ route('articles.show', $article->slug) }}" class="text-gray-900 hover:text-blue-600 transition-colors">
                                    {{ $article->title }}
                                </a>
                            </h2>
                            <p class="text-gray-600 text-sm mb-2">
                                By {{ $article->author->name }}
                            </p>
                            <p class="text-gray-700 text-sm line-clamp-2">
                                {{ strip_tags($article->content) }}
                            </p>
                            <a href="{{ route('articles.show', $article->slug) }}" class="inline-block mt-2 text-blue-500 text-sm hover:underline">Read more</a>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="mt-4">
                {{ $articles->links() }}
            </div>
        @endif
    </div>
@endsection