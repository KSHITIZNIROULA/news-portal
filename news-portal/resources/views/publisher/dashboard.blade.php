<!-- resources/views/publisher/dashboard.blade.php -->
@extends('layouts.publisher')

@section('content')
    <div class="container mx-auto p-4 max-w-5xl">
        <h1 class="text-2xl font-bold mb-4 text-gray-900">Publisher Dashboard</h1>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <div class="bg-white p-4 rounded-lg shadow">
                <h2 class="text-lg font-semibold text-gray-800">Total Articles</h2>
                <p class="text-2xl font-bold text-gray-900">{{ $totalArticles }}</p>
            </div>
            <div class="bg-white p-4 rounded-lg shadow">
                <h2 class="text-lg font-semibold text-gray-800">Published Articles</h2>
                <p class="text-2xl font-bold text-gray-900">{{ $publishedArticles }}</p>
            </div>
        </div>
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-bold text-gray-900">Your Articles</h2>
            <a href="{{ route('publisher.articles.create') }}" class="bg-blue-500 text-white px-3 py-1.5 rounded hover:bg-blue-600 text-sm">Create New Article</a>
        </div>
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-3 py-2 rounded mb-3 text-sm">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-3 py-2 rounded mb-3 text-sm">
                {{ session('error') }}
            </div>
        @endif
        @if($articles->isEmpty())
            <p class="text-center text-gray-500 text-sm py-4">No articles available at the moment.</p>
        @else
            <div class="overflow-x-auto">
                <table class="w-full border-collapse bg-white shadow-sm rounded-lg">
                    <thead>
                        <tr class="bg-gray-100 text-gray-700 text-sm">
                            <th class="p-2 text-left">Title</th>
                            <th class="p-2 text-left">Category</th>
                            <th class="p-2 text-left">Status</th>
                            <th class="p-2 text-left">Published At</th>
                            <th class="p-2 text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($articles as $article)
                            <tr class="border-b hover:bg-gray-50 text-sm">
                                <td class="p-2">{{ $article->title }}</td>
                                <td class="p-2">{{ $article->category->name }}</td>
                                <td class="p-2">
                                    <span class="inline-block px-2 py-0.5 rounded text-xs font-semibold {{ $article->status === 'published' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                        {{ ucfirst($article->status) }}
                                    </span>
                                </td>
                                <td class="p-2">{{ $article->published_at ? $article->published_at->format('M d, Y H:i') : 'N/A' }}</td>
                                <td class="p-2 flex space-x-2">
                                    <a href="{{ route('publisher.articles.show', $article) }}" class="bg-gray-200 text-gray-700 px-2 py-1 rounded text-xs hover:bg-gray-300">View</a>
                                    <a href="{{ route('publisher.articles.edit', $article) }}" class="bg-blue-200 text-blue-700 px-2 py-1 rounded text-xs hover:bg-blue-300">Edit</a>
                                    <form action="{{ route('publisher.articles.destroy', $article) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this article?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-200 text-red-700 px-2 py-1 rounded text-xs hover:bg-red-300">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-4">
                {{ $articles->links() }}
            </div>
        @endif
    </div>
@endsection