@extends('admin.dashboard')

@section('content')
    <div class="container mx-auto p-6 max-w-6xl">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-900">Manage Users (User Role)</h1>
            <a href="{{ route('admin.users.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 text-base">Create New User</a>
        </div>
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-4 text-base">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-4 text-base">
                {{ session('error') }}
            </div>
        @endif
        @if($users->isEmpty())
            <p class="text-center text-gray-500 text-base py-6">No users with the 'user' role available at the moment.</p>
        @else
            <div class="overflow-x-auto">
                <table class="w-full border-collapse bg-white shadow-sm rounded-lg">
                    <thead>
                        <tr class="bg-gray-100 text-gray-700 text-base">
                            <th class="p-3 text-left">Name</th>
                            <th class="p-3 text-left">Email</th>
                            <th class="p-3 text-left">Role</th>
                            <th class="p-3 text-left">Created At</th>
                            <th class="p-3 text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            <tr class="border-b hover:bg-gray-50 text-base">
                                <td class="p-3">{{ $user->name }}</td>
                                <td class="p-3">{{ $user->email }}</td>
                                <td class="p-3">{{ $user->roles->pluck('name')->implode(', ') }}</td>
                                <td class="p-3">{{ $user->created_at->format('M d, Y H:i') }}</td>
                                <td class="p-3 flex space-x-3">
                                    {{-- <a href="{{ route('admin.users.show', $user) }}" class="bg-gray-200 text-gray-700 px-3 py-1.5 rounded-lg text-sm hover:bg-gray-300">View</a> --}}
                                    <a href="{{ route('admin.users.edit', $user) }}" class="bg-blue-200 text-blue-700 px-3 py-1.5 rounded-lg text-sm hover:bg-blue-300">Edit</a>
                                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this user?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-200 text-red-700 px-3 py-1.5 rounded-lg text-sm hover:bg-red-300">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-6">
                {{ $users->links() }}
            </div>
        @endif
    </div>
@endsection