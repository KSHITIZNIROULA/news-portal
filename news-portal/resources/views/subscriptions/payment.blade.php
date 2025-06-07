<!-- resources/views/subscriptions/payment.blade.php -->
@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto bg-white p-8 rounded-lg shadow mt-10">
    <h1 class="text-2xl font-bold mb-6">Subscribe to {{ $publisher->name }}</h1>
    
    <!-- Fake Payment Form -->
    <form action="{{ route('subscriptions.store', $publisher) }}" method="POST">
        @csrf
        
        <div class="mb-4">
            <label class="block text-gray-700 mb-2">Card Number</label>
            <input type="text" value="4242 4242 4242 4242" 
                   class="w-full px-4 py-2 border rounded-lg" readonly>
        </div>

        <div class="grid grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-gray-700 mb-2">Expiry</label>
                <input type="text" value="12/25" 
                       class="w-full px-4 py-2 border rounded-lg" readonly>
            </div>
            <div>
                <label class="block text-gray-700 mb-2">CVC</label>
                <input type="text" value="123" 
                       class="w-full px-4 py-2 border rounded-lg" readonly>
            </div>
        </div>

        <button type="submit" 
                class="w-full bg-green-500 text-white py-2 rounded-lg hover:bg-green-600">
            Pay $0.00 (Demo)
        </button>

        <p class="mt-4 text-sm text-gray-500 text-center">
            This is a dummy payment. No real charges will occur.
        </p>
    </form>
</div>
@endsection