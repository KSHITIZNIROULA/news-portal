@extends('admin.dashboard')
@section('content')
                    <div class="bg-white overflow-hidden shadow rounded-lg">
                        <div class="px-4 py-5 sm:p-6">
                            <h3 class="text-lg font-medium leading-6 text-gray-900">Welcome, {{ Auth::user()->name }}
                            </h3>
                            <div class="mt-2 max-w-xl text-sm text-gray-500">
                                <p>You're logged in as
                                    {{ Auth::user()->hasRole('admin') ? 'an admin' : 'a publisher' }}.</p>
                            </div>
                        </div>
@endsection