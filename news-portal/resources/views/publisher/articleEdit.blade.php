@extends('layouts.publisher')

@section('content')
    <div class="container mx-auto p-4 max-w-lg">
        <h1 class="text-2xl font-bold mb-4 text-gray-800">Edit Article</h1>

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

        <form action="{{ route('publisher.articles.update', $article) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Title -->
            <div class="mb-4">
                <label for="title" class="block text-gray-700 font-medium text-sm mb-1">Title</label>
                <input 
                    type="text" 
                    name="title" 
                    id="title" 
                    class="w-full border rounded p-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 @error('title') border-red-500 @enderror" 
                    value="{{ old('title', $article->title) }}" 
                    required 
                    placeholder="Enter article title"
                >
                @error('title')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Content -->
            <div class="mb-4">
                <label for="content" class="block text-gray-700 font-medium text-sm mb-1">Content</label>
                <textarea 
                    name="content" 
                    id="content" 
                    rows="8" 
                    class="w-full border rounded p-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 @error('content') border-red-500 @enderror" 
                    required 
                    placeholder="Write your article content here..."
                >{{ old('content', $article->content) }}</textarea>
                @error('content')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Category -->
            <div class="mb-4">
                <label for="category_id" class="block text-gray-700 font-medium text-sm mb-1">Category (Optional)</label>
                <select 
                    name="category_id" 
                    id="category_id" 
                    class="w-full border rounded p-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 @error('category_id') border-red-500 @enderror"
                >
                    <option value="" {{ old('category_id', $article->category_id) ? '' : 'selected' }}>No category</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id', $article->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>
                @error('category_id')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Status -->
            <div class="mb-4">
                <label for="status" class="block text-gray-700 font-medium text-sm mb-1">Status</label>
                <select 
                    name="status" 
                    id="status" 
                    class="w-full border rounded p-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 @error('status') border-red-500 @enderror"
                    required
                >
                    <option value="draft" {{ old('status', $article->status) == 'draft' ? 'selected' : '' }}>Draft</option>
                    <option value="published" {{ old('status', $article->status) == 'published' ? 'selected' : '' }}>Published</option>
                </select>
                @error('status')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Publish Date -->
            <div class="mb-4">
                <label for="published_at" class="block text-gray-700 font-medium text-sm mb-1">Publish Date (Optional)</label>
                <input 
                    type="datetime-local" 
                    name="published_at" 
                    id="published_at" 
                    class="w-full border rounded p-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 @error('published_at') border-red-500 @enderror" 
                    value="{{ old('published_at', $article->published_at ? $article->published_at->format('Y-m-d\TH:i') : '') }}"
                >
                @error('published_at')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
                <p class="text-gray-500 text-xs mt-1">Leave blank for drafts or set to current/future date for published articles.</p>
            </div>

            <!-- Exclusive Checkbox -->
            <div class="mb-4">
                <label for="is_exclusive" class="block text-gray-700 font-medium text-sm mb-1">Exclusive (Subscriber-Only)</label>
                <input 
                    type="checkbox" 
                    name="is_exclusive" 
                    id="is_exclusive" 
                    value="1" 
                    class="mr-2 h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded" 
                    {{ old('is_exclusive', $article->is_exclusive) ? 'checked' : '' }}
                >
                <span class="text-gray-600 text-sm">Check to make this article exclusive to subscribers.</span>
                @error('is_exclusive')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Images -->
            <div class="mb-4">
                <label for="images" class="block text-gray-700 font-medium text-sm mb-1">Add Images (Optional, Max 3)</label>
                <input 
                    type="file" 
                    name="images[]" 
                    id="images" 
                    class="w-full border rounded p-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 @error('images.*') border-red-500 @enderror" 
                    multiple 
                    accept="image/jpeg,image/png"
                >
                @error('images.*')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
                <p class="text-gray-500 text-xs mt-1">Upload up to 3 images (JPEG/PNG, max 5MB each).</p>
                @if($article->images->count() > 0)
                    <div class="mt-3">
                        <p class="text-gray-700 text-sm mb-2">Existing Images:</p>
                        <div class="flex flex-wrap gap-3" id="image-previews">
                            @foreach($article->images as $image)
                                <div class="relative" data-image-path="{{ $image->path }}">
                                    <img src="{{ asset('storage/' . $image->path) }}" alt="Article Image" class="w-20 h-20 object-cover rounded border">
                                    <button 
                                        type="button" 
                                        onclick="removeImage('{{ $image->path }}', this)" 
                                        class="absolute top-0 right-0 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs hover:bg-red-600"
                                    >×</button>
                                </div>
                            @endforeach
                        </div>
                        <input type="hidden" name="remove_images[]" id="remove_images" value="">
                    </div>
                @endif
            </div>

            <!-- Buttons -->
            <div class="flex justify-end space-x-2">
                <a href="{{ route('publisher.articles.dashboard') }}" class="bg-gray-200 text-gray-700 px-3 py-1.5 rounded hover:bg-gray-300 text-sm transition-colors">Cancel</a>
                <button type="submit" class="bg-blue-500 text-white px-3 py-1.5 rounded hover:bg-blue-600 text-sm transition-colors">Update Article</button>
            </div>
        </form>
    </div>

    <script>
        function removeImage(path, button) {
            if (confirm('Are you sure you want to remove this image?')) {
                // Create a new hidden input for the removed image path
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'remove_images[]';
                input.value = path;
                document.querySelector('form').appendChild(input);

                // Remove the image preview
                button.closest('[data-image-path]').remove();
            }
        }
    </script>
@endsection