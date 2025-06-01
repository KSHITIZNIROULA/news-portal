<!-- resources/views/publisher/articleCreate.blade.php -->
@extends('layouts.publisher')

@section('content')
    <div class="container mx-auto p-4 max-w-lg">
        <h1 class="text-2xl font-bold mb-4 text-gray-800">Create New Article</h1>
        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-3 py-2 rounded mb-3 text-sm">
                {{ session('error') }}
            </div>
        @endif
        <form action="{{ route('publisher.articles.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="title" class="block text-gray-700 font-medium text-sm mb-1">Title</label>
                <input type="text" name="title" id="title" class="w-full border rounded p-1.5 text-sm focus:outline-none @error('title') border-red-500 @enderror" value="{{ old('title') }}" required>
                @error('title')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-3">
                <label for="content" class="block text-gray-700 font-medium text-sm mb-1">Content</label>
                <textarea name="content" id="content" rows="6" class="w-full border rounded p-1.5 text-sm focus:outline-none @error('content') border-red-500 @enderror" required>{{ old('content') }}</textarea>
                @error('content')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-3">
                <label for="category_id" class="block text-gray-700 font-medium text-sm mb-1">Category</label>
                <select name="category_id" id="category_id" class="w-full border rounded p-1.5 text-sm focus:outline-none @error('category_id') border-red-500 @enderror" required>
                    <option value="">Select a category</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>
                @error('category_id')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-3">
                <label for="status" class="block text-gray-700 font-medium text-sm mb-1">Status</label>
                <select name="status" id="status" class="w-full border rounded p-1.5 text-sm focus:outline-none @error('status') border-red-500 @enderror">
                    <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                    <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>Published</option>
                </select>
                @error('status')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-3">
                <label for="published_at" class="block text-gray-700 font-medium text-sm mb-1">Publish Date (Optional)</label>
                <input type="datetime-local" name="published_at" id="published_at" class="w-full border rounded p-1.5 text-sm focus:outline-none @error('published_at') border-red-500 @enderror" value="{{ old('published_at') }}">
                @error('published_at')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-3">
                <label for="images" class="block text-gray-700 font-medium text-sm mb-1">Images (Optional)</label>
                <input type="file" name="images[]" id="images" class="w-full border rounded p-1.5 text-sm focus:outline-none @error('images') border-red-500 @enderror" multiple accept="image/*">
                @error('images')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="flex justify-end space-x-2">
                <a href="{{ route('publisher.articles.dashboard') }}" class="bg-gray-200 text-gray-700 px-3 py-1.5 rounded hover:bg-gray-300 text-sm">Cancel</a>
                <button type="submit" class="bg-blue-500 text-white px-3 py-1.5 rounded hover:bg-blue-600 text-sm">Create Article</button>
            </div>
        </form>
    </div>
@endsection