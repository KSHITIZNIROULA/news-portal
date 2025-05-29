@extends('admin.dashboard')
@section('content')

<div class="container mx-auto p-6 max-w-2xl">
    <h1 class="text-3xl font-bold mb-6 text-gray-800">Create New Article</h1>
    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4 text-base">
            {{ session('error') }}
        </div>
    @endif
    <form action="{{ route('admin.articles.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-4">
            <label for="title" class="block text-gray-700 font-medium text-base mb-2">Title</label>
            <input type="text" name="title" id="title" class="w-full border rounded p-2 text-base focus:outline-none focus:ring-2 focus:ring-blue-500 @error('title') border-red-500 @enderror" value="{{ old('title') }}" required>
            @error('title')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-4">
            <label for="content" class="block text-gray-700 font-medium text-base mb-2">Content</label>
            <textarea name="content" id="content" class="w-full border rounded p-2 text-base focus:outline-none focus:ring-2 focus:ring-blue-500 @error('content') border-red-500 @enderror" rows="5" required>{{ old('content') }}</textarea>
            @error('content')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-4">
            <label for="category_id" class="block text-gray-700 font-medium text-base mb-2">Category</label>
            <select name="category_id" id="category_id" class="w-full border rounded p-2 text-base focus:outline-none focus:ring-2 focus:ring-blue-500 @error('category_id') border-red-500 @enderror" required>
                <option value="">Select Category</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                @endforeach
            </select>
            @error('category_id')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-4">
            <label for="status" class="block text-gray-700 font-medium text-base mb-2">Status</label>
            <select name="status" id="status" class="w-full border rounded p-2 text-base focus:outline-none focus:ring-2 focus:ring-blue-500 @error('status') border-red-500 @enderror">
                <option value="draft" {{ old('status', 'draft') == 'draft' ? 'selected' : '' }}>Draft</option>
                <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>Published</option>
            </select>
            @error('status')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-4">
            <label for="published_at" class="block text-gray-700 font-medium text-base mb-2">Publish Date (if Published)</label>
            <input type="datetime-local" name="published_at" id="published_at" class="w-full border rounded p-2 text-base focus:outline-none focus:ring-2 focus:ring-blue-500 @error('published_at') border-red-500 @enderror" value="{{ old('published_at') }}">
            @error('published_at')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-4">
            <label for="images" class="block text-gray-700 font-medium text-base mb-2">Images (Optional)</label>
            <input type="file" name="images[]" id="images" class="w-full border rounded p-2 text-base focus:outline-none @error('images') border-red-500 @enderror" multiple accept="image/*" onchange="previewImages(event)">
            @error('images')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
            <div id="imagePreview" class="mt-3 flex flex-wrap gap-3"></div>
        </div>
        <div class="flex justify-end">
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 text-base">Create Article</button>
        </div>
    </form>

    <script>
        function previewImages(event) {
            const preview = document.getElementById('imagePreview');
            preview.innerHTML = ''; // Clear previous previews
            const files = event.target.files;
            for (let i = 0; i < files.length; i++) {
                const file = files[i];
                if (file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.className = 'w-20 h-20 object-cover rounded border';
                        preview.appendChild(img);
                    };
                    reader.readAsDataURL(file);
                }
            }
        }
    </script>
</div>

@endsection