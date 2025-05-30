<!-- resources/views/admin/articleShow.blade.php -->
@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4 max-w-3xl">
        <h1 class="text-3xl font-bold mb-4 text-gray-900">{{ $article->title }}</h1>
        <div class="flex items-center mb-4 text-sm text-gray-600">
            <span>Category: {{ $article->category->name }}</span>
            <span class="mx-2">•</span>
            <span>Author: {{ $article->author->name }}</span>
            <span class="mx-2">•</span>
            <span>Status: 
                <span class="inline-block px-2 py-0.5 rounded text-xs font-semibold {{ $article->status === 'published' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                    {{ ucfirst($article->status) }}
                </span>
            </span>
            <span class="mx-2">•</span>
            <span>Published: {{ $article->published_at ? $article->published_at->format('M d, Y H:i') : 'N/A' }}</span>
        </div>
        
        @if($article->images->count() > 0)
            <div class="mb-4">
                <h2 class="text-lg font-semibold mb-2 text-gray-800">Images</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($article->images as $image)
                        <img src="{{ asset('storage/' . $image->path) }}" alt="{{ $article->title }} Image" class="w-full h-48 object-cover rounded-lg shadow-md">
                    @endforeach
                </div>
            </div>
        @endif

        <div class="prose max-w-none mb-4">
            {!! $article->content !!}
        </div>

        <div class="flex space-x-4">
            <a href="{{ route('admin.articles.index') }}" class="bg-gray-200 text-gray-700 px-3 py-1.5 rounded hover:bg-gray-300 text-sm">Back to List</a>
            @if(Auth::check() && (Auth::user()->hasRole('admin') || Auth::id() === $article->author_id))
                <a href="{{ route('admin.articles.edit', $article) }}" class="bg-blue-500 text-white px-3 py-1.5 rounded hover:bg-blue-600 text-sm">Edit</a>
            @endif
        </div>
    </div>
@endsection