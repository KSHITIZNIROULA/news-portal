@extends('admin.dashboard')

@section('content')
    <div class="container mx-auto p-6 max-w-4xl">
        <h1 class="text-3xl font-bold mb-6 text-gray-800">Edit Article</h1>
        
        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4 text-sm">
                {{ session('error') }}
            </div>
        @endif
        
        <form action="{{ route('admin.articles.update', $article) }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-lg shadow-md p-6">
            @csrf
            @method('PUT')
            
            <div class="space-y-6">
                <!-- Title Field -->
                <div>
                    <label for="title" class="block text-gray-700 font-medium text-base mb-2">Title</label>
                    <input type="text" name="title" id="title" 
                           class="w-full border rounded-lg p-3 text-base focus:outline-none focus:ring-2 focus:ring-blue-500 @error('title') border-red-500 @enderror" 
                           value="{{ old('title', $article->title) }}" required>
                    @error('title')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Content Field -->
                <div>
                    <label for="content" class="block text-gray-700 font-medium text-base mb-2">Content</label>
                    <textarea name="content" id="content" 
                              class="w-full border rounded-lg p-3 text-base focus:outline-none focus:ring-2 focus:ring-blue-500 @error('content') border-red-500 @enderror" 
                              rows="6" required>{{ old('content', $article->content) }}</textarea>
                    @error('content')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Category Field -->
                <div>
                    <label for="category_id" class="block text-gray-700 font-medium text-base mb-2">Category</label>
                    <select name="category_id" id="category_id" 
                            class="w-full border rounded-lg p-3 text-base focus:outline-none focus:ring-2 focus:ring-blue-500 @error('category_id') border-red-500 @enderror" required>
                        <option value="">Select Category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id', $article->category_id) == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Status Field -->
                <div>
                    <label for="status" class="block text-gray-700 font-medium text-base mb-2">Status</label>
                    <select name="status" id="status" 
                            class="w-full border rounded-lg p-3 text-base focus:outline-none focus:ring-2 focus:ring-blue-500 @error('status') border-red-500 @enderror">
                        <option value="draft" {{ old('status', $article->status) == 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="published" {{ old('status', $article->status) == 'published' ? 'selected' : '' }}>Published</option>
                    </select>
                    @error('status')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Publish Date Field -->
                <div>
                    <label for="published_at" class="block text-gray-700 font-medium text-base mb-2">Publish Date (if Published)</label>
                    <input type="datetime-local" name="published_at" id="published_at" 
                           class="w-full border rounded-lg p-3 text-base focus:outline-none focus:ring-2 focus:ring-blue-500 @error('published_at') border-red-500 @enderror" 
                           value="{{ old('published_at', $article->published_at ? $article->published_at->format('Y-m-d\TH:i') : '') }}">
                    @error('published_at')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Images Field -->
                <div>
                    <label for="images" class="block text-gray-700 font-medium text-base mb-2">Images (Optional)</label>
                    <input type="file" name="images[]" id="images" 
                           class="w-full border rounded-lg p-3 text-base focus:outline-none @error('images') border-red-500 @enderror" 
                           multiple accept="image/*" onchange="previewImages(event)">
                    @error('images')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                    
                    <div id="imagePreview" class="mt-4 flex flex-wrap gap-4"></div>
                    
                    @if($article->image && count($article->image) > 0)
                        <div class="mt-4">
                            <p class="text-gray-700 text-base mb-2">Existing Images:</p>
                            <div class="flex flex-wrap gap-4">
                                @foreach($article->image as $image)
                                    <div class="relative">
                                        <img src="{{ asset('storage/' . $image) }}" alt="Article Image" class="w-24 h-24 object-cover rounded-lg border">
                                        <button type="button" onclick="removeImage('{{ $image }}', this)" 
                                                class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-sm hover:bg-red-600">
                                            ×
                                        </button>
                                    </div>
                                @endforeach
                            </div>
                            <input type="hidden" name="remove_images[]" id="remove_images" value="">
                        </div>
                    @endif
                </div>
                
                <!-- Buttons -->
                <div class="flex justify-end space-x-4 pt-4">
                    <a href="{{ route('admin.articles.index') }}" 
                       class="bg-gray-200 text-gray-700 px-5 py-2.5 rounded-lg hover:bg-gray-300 text-base font-medium transition">
                        Cancel
                    </a>
                    <button type="submit" 
                            class="bg-blue-600 text-white px-5 py-2.5 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 text-base font-medium transition">
                        Update Article
                    </button>
                </div>
            </div>
        </form>
    </div>

    <script>
        function previewImages(event) {
            const preview = document.getElementById('imagePreview');
            preview.innerHTML = '';
            const files = event.target.files;
            
            for (let i = 0; i < files.length; i++) {
                const file = files[i];
                if (file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.className = 'w-24 h-24 object-cover rounded-lg border';
                        preview.appendChild(img);
                    };
                    reader.readAsDataURL(file);
                }
            }
        }

        function removeImage(imagePath, button) {
            let removeImagesInput = document.getElementById('remove_images');
            let currentValue = removeImagesInput.value ? removeImagesInput.value.split(',') : [];
            currentValue.push(imagePath);
            removeImagesInput.value = currentValue.join(',');
            button.parentElement.remove();
        }
    </script>
@endsection