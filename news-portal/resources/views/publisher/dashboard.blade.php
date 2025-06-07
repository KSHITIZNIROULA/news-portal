@extends('layouts.publisher')

@section('content')
    <div class="container mx-auto p-4 max-w-5xl">
        <h1 class="text-2xl font-bold mb-4 text-gray-900">Publisher Dashboard</h1>

        <!-- Success/Error Messages -->
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-3 py-2 rounded mb-4 text-sm">
                {{ session('success') }}
            </div>
        @elseif(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-3 py-2 rounded mb-4 text-sm">
                {{ session('error') }}
            </div>
        @endif

        <!-- Statistics -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            <div class="bg-white p-4 rounded-lg shadow">
                <h2 class="text-lg font-semibold text-gray-800">Total Articles</h2>
                <p class="text-2xl font-bold text-gray-900">{{ $totalArticles }}</p>
            </div>
            <div class="bg-white p-4 rounded-lg shadow">
                <h2 class="text-lg font-semibold text-gray-800">Published Articles</h2>
                <p class="text-2xl font-bold text-gray-900">{{ $publishedArticles }}</p>
            </div>
            <div class="bg-white p-4 rounded-lg shadow">
                <h2 class="text-lg font-semibold text-gray-800">Exclusive Articles</h2>
                <p class="text-2xl font-bold text-gray-900">{{ $exclusiveArticles }}</p>
            </div>
        </div>

        <!-- Articles Table -->
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-bold text-gray-900">Your Articles</h2>
            <a href="{{ route('publisher.articles.create') }}" class="bg-blue-500 text-white px-3 py-1.5 rounded hover:bg-blue-600 text-sm transition-colors">Create New Article</a>
        </div>

        @if($articles->isEmpty())
            <div class="text-center py-8 bg-white rounded-lg shadow-sm">
                <p class="text-gray-500 text-sm mb-2">You haven't created any articles yet.</p>
                <a href="{{ route('publisher.articles.create') }}" class="text-blue-600 text-sm hover:underline">Start by creating your first article!</a>
            </div>
        @else
            <div class="overflow-x-auto bg-white shadow-sm rounded-lg">
                <table class="w-full border-collapse text-sm">
                    <thead>
                        <tr class="bg-gray-100 text-gray-700">
                            <th class="p-3 text-left font-semibold">Title</th>
                            <th class="p-3 text-left font-semibold">Category</th>
                            <th class="p-3 text-left font-semibold">Status</th>
                            <th class="p-3 text-left font-semibold">Exclusive</th>
                            <th class="p-3 text-left font-semibold">Published At</th>
                            <th class="p-3 text-left font-semibold">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($articles as $article)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="p-3">
                                    <a href="{{ route('publisher.articles.show', $article) }}" class="text-blue-600 hover:underline">{{ $article->title }}</a>
                                    @if($article->images->isNotEmpty())
                                        <img src="{{ asset('storage/' . $article->images->first()->path) }}" alt="Thumbnail" class="w-12 h-12 object-cover inline-block ml-2 rounded">
                                    @endif
                                </td>
                                <td class="p-3">{{ $article->category ? $article->category->name : 'Uncategorized' }}</td>
                                <td class="p-3">
                                    <span class="inline-block px-2 py-0.5 rounded text-xs font-semibold {{ $article->status === 'published' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                        {{ ucfirst($article->status) }}
                                    </span>
                                </td>
                                <td class="p-3">
                                    <span class="inline-block px-2 py-0.5 rounded text-xs font-semibold {{ $article->is_exclusive ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800' }}">
                                        {{ $article->is_exclusive ? 'Yes' : 'No' }}
                                    </span>
                                </td>
                                <td class="p-3">{{ $article->published_at ? $article->published_at->format('M d, Y H:i') : 'Draft' }}</td>
                                <td class="p-3 flex space-x-2">
                                    <a href="{{ route('publisher.articles.show', $article) }}" class="bg-gray-200 text-gray-700 px-2 py-1 rounded text-xs hover:bg-gray-300 transition-colors" title="View article">View</a>
                                    <a href="{{ route('publisher.articles.edit', $article) }}" class="bg-blue-200 text-blue-700 px-2 py-1 rounded text-xs hover:bg-blue-300 transition-colors" title="Edit article">Edit</a>
                                    <form action="{{ route('publisher.articles.destroy', $article) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this article?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-200 text-red-700 px-2 py-1 rounded text-xs hover:bg-red-300 transition-colors" title="Delete article">Delete</button>
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