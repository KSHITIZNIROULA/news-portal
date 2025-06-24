@extends('layouts.publisher')

@section('content')
    <div class="container mx-auto p-4 max-w-lg">
        <h1 class="text-2xl font-bold mb-4 text-gray-800">Create New Article</h1>
        
    

        <form action="{{ route('publisher.articles.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Title -->
            <div class="mb-3">
                <label for="title" class="block text-gray-700 font-medium text-sm mb-1">Title</label>
                <input 
                    type="text" 
                    name="title" 
                    id="title" 
                    class="w-full border rounded p-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 @error('title') border-red-500 @enderror" 
                    value="{{ old('title') }}" 
                    required 
                    placeholder="Enter article title"
                >
                @error('title')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Content -->
            <div class="mb-3">
                <label for="content" class="block text-gray-700 font-medium text-sm mb-1">Content</label>
                <textarea 
                    name="content" 
                    id="content" 
                    rows="8" 
                    class="w-full border rounded p-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 @error('content') border-red-500 @enderror" 
                    required 
                    placeholder="Write your article content here..."
                >{{ old('content') }}</textarea>
                @error('content')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Category -->
            <div class="mb-3">
                <label for="category_id" class="block text-gray-700 font-medium text-sm mb-1">Category</label>
                <select 
                    name="category_id" 
                    id="category_id" 
                    class="w-full border rounded p-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 @error('category_id') border-red-500 @enderror"
                >
                    <option value="" {{ old('category_id') ? '' : 'selected' }} disabled>Select a category</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>
                @error('category_id')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Status -->
            <div class="mb-3">
                <label for="status" class="block text-gray-700 font-medium text-sm mb-1">Status</label>
                <select 
                    name="status" 
                    id="status" 
                    class="w-full border rounded p-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 @error('status') border-red-500 @enderror"
                >
                    <option value="draft" {{ old('status', 'draft') == 'draft' ? 'selected' : '' }}>Draft</option>
                    <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>Published</option>
                </select>
                @error('status')
                    <p class="text-red-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Publish Date -->
            <div class="mb-3">
                <label for="published_at" class="block text-gray-700 font-medium text-sm mb-1">Publish Date (Optional)</label>
                <input 
                    type="datetime-local" 
                    name="published_at" 
                    id="published_at" 
                    class="w-full border rounded p-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 @error('published_at') border-red-500 @enderror" 
                    value="{{ old('published_at') ? old('published_at') : now()->format('Y-m-d\TH:i') }}"
                >
                @error('published_at')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
                <p class="text-gray-500 text-xs mt-1">Leave blank for drafts or set to current/future date for published articles.</p>
            </div>

            <!-- Exclusive Checkbox -->
            <div class="mb-3">
                <label for="is_exclusive" class="flex items-center">
                    <input 
                        type="checkbox" 
                        name="is_exclusive" 
                        id="is_exclusive" 
                        value="1" 
                        class="mr-2 h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded" 
                        {{ old('is_exclusive') ? 'checked' : '' }}
                    >
                    <span class="text-gray-700 font-medium text-sm">Mark as Exclusive (Subscribers Only)</span>
                </label>
                @error('is_exclusive')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
                <p class="text-gray-500 text-xs mt-1">Exclusive articles are only visible to your subscribers or admins.</p>
            </div>

            <!-- Images -->
            <div class="mb-3">
                <label for="images" class="block text-gray-700 font-medium text-sm mb-1">Images (Optional, max 5MB each)</label>
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
                <p class="text-gray-500 text-xs mt-1">Upload up to 3 images (JPEG, PNG, max 5MB each).</p>
            </div>

            <!-- Form Actions -->
            <div class="flex justify-end space-x-2">
                <a href="{{ route('publisher.articles.dashboard') }}" class="bg-gray-200 text-gray-700 px-3 py-1.5 rounded hover:bg-gray-300 text-sm transition-colors">Cancel</a>
                <button type="submit" class="bg-blue-500 text-white px-3 py-1.5 rounded hover:bg-blue-600 text-sm transition-colors">Create Article</button>
            </div>
        </form>
    </div>

<script>
    document.getElementById('status').addEventListener('change', function () {
        if (this.value === 'published') {
            const input = document.getElementById('published_at');
            if (!input.value) {
                const now = new Date();
                input.value = now.toISOString().slice(0, 16);
            }
        }
    });
</script>
@endsection