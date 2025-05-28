@extends('admin.dashboard')
@section('content')
<div class="max-w-md mx-auto bg-white rounded-lg shadow-md overflow-hidden p-6">
    <h2 class="text-xl font-semibold text-gray-800 mb-6">Create New Category</h2>
    <form action="{{ route('admin.categories.store') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Category Name</label>
            <input 
                type="text" 
                id="name" 
                name="name" 
                required
                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                placeholder="Enter category name"
            >
            @error('name')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
        <div class="flex justify-end">
            <button 
                type="submit" 
                class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition"
            >
                Create Category
            </button>
        </div>
    </form>
</div>
@endsection