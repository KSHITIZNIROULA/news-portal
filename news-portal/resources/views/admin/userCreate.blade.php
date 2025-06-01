<!-- resources/views/admin/userCreate.blade.php -->
@extends('admin.dashboard')

@section('content')
    <div class="container mx-auto p-4 max-w-lg">
        <h1 class="text-2xl font-bold mb-4 text-gray-800">Create New User</h1>
        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-3 py-2 rounded mb-3 text-sm">
                {{ session('error') }}
            </div>
        @endif
        <form action="{{ route('admin.users.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="name" class="block text-gray-700 font-medium text-sm mb-1">Name</label>
                <input type="text" name="name" id="name" class="w-full border rounded p-1.5 text-sm focus:outline-none focus:ring-1 focus:ring-blue-500 @error('name') border-red-500 @enderror" value="{{ old('name') }}" required>
                @error('name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-3">
                <label for="email" class="block text-gray-700 font-medium text-sm mb-1">Email</label>
                <input type="email" name="email" id="email" class="w-full border rounded p-1.5 text-sm focus:outline-none focus:ring-1 focus:ring-blue-500 @error('email') border-red-500 @enderror" value="{{ old('email') }}" required>
                @error('email')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-3">
                <label for="password" class="block text-gray-700 font-medium text-sm mb-1">Password</label>
                <input type="password" name="password" id="password" class="w-full border rounded p-1.5 text-sm focus:outline-none focus:ring-1 focus:ring-blue-500 @error('password') border-red-500 @enderror" required>
                @error('password')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-3">
                <label for="password_confirmation" class="block text-gray-700 font-medium text-sm mb-1">Confirm Password</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="w-full border rounded p-1.5 text-sm focus:outline-none focus:ring-1 focus:ring-blue-500">
            </div>
            <div class="mb-3">
                <label for="role" class="block text-gray-700 font-medium text-sm mb-1">Role</label>
                <select name="role" id="role" class="w-full border rounded p-1.5 text-sm focus:outline-none focus:ring-1 focus:ring-blue-500 @error('role') border-red-500 @enderror" required>
                    <option value="user" {{ old('role') === 'user' ? 'selected' : '' }}>User</option>
                </select>
                @error('role')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="flex justify-end space-x-2">
                <a href="{{ route('admin.users.index') }}" class="bg-gray-200 text-gray-700 px-3 py-1.5 rounded hover:bg-gray-300 text-sm">Cancel</a>
                <button type="submit" class="bg-blue-500 text-white px-3 py-1.5 rounded hover:bg-blue-600 focus:outline-none focus:ring-1 focus:ring-blue-500 text-sm">Create User</button>
            </div>
        </form>
    </div>
@endsection