@extends('layouts.publisher')

@section('content')
    <div class="container mx-auto px-4 py-6">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
            <h1 class="text-2xl font-bold text-gray-900">My Subscribers</h1>

            <div class="flex flex-col sm:flex-row gap-4">
                <div class="bg-white rounded-lg shadow px-4 py-3 text-center">
                    <div class="text-gray-600 text-sm">Total Subscribers</div>
                    <div class="text-2xl font-bold">{{ $subscribers->total() }}</div>
                </div>
                <div class="bg-white rounded-lg shadow px-4 py-3 text-center">
                    <div class="text-gray-600 text-sm">New This Month</div>
                    <div class="text-2xl font-bold">{{ $newThisMonthCount }}</div>
                </div>
            </div>
        </div>

        @if ($subscribers->isEmpty())
            <div class="bg-white rounded-lg shadow p-6 text-center">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
                <h3 class="mt-2 text-lg font-medium text-gray-900">No subscribers yet</h3>
                <p class="mt-1 text-gray-500">Your subscribers will appear here when they sign up.</p>
            </div>
        @else
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Subscriber</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Contact</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Subscription Details</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($subscribers as $subscription)
                            @php
                                $duration = $subscription->created_at->diffForHumans();
                                $monthsSubscribed = $subscription->created_at->diffInMonths(now());
                                $daysSubscribed = $subscription->created_at->diffInDays(now());
                            @endphp
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div
                                            class="flex-shrink-0 h-10 w-10 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center font-medium">
                                            {{ substr($subscription->user->name, 0, 1) }}
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $subscription->user->name }}
                                            </div>
                                            <div class="text-sm text-gray-500">
                                                @if ($monthsSubscribed > 0)
                                                    Subscribed for {{ $monthsSubscribed }}
                                                    {{ Str::plural('month', $monthsSubscribed) }}
                                                @else
                                                    Subscribed for {{ $daysSubscribed }}
                                                    {{ Str::plural('day', $daysSubscribed) }}
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $subscription->user->email }}</div>
                                    <div class="text-sm text-gray-500">
                                        @if ($subscription->user->last_login_at)
                                            Last active {{ $subscription->user->last_login_at->diffForHumans() }}
                                        @else
                                            Never logged in
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">
                                        Since {{ $subscription->created_at->format('M j, Y') }}
                                        <span class="text-gray-500">({{ $duration }})</span>
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        @if ($subscription->expires_at)
                                            @if ($subscription->expires_at->isFuture())
                                                Expires in {{ $subscription->expires_at->diffForHumans() }}
                                            @else
                                                Expired {{ $subscription->expires_at->diffForHumans() }}
                                            @endif
                                        @else
                                            No expiration
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <form action="{{ route('publisher.subscribers.remove', $subscription->user) }}"
                                        method="POST">
                                        @csrf
                                        <button type="submit" class="text-red-600 hover:text-red-900"
                                            onclick="return confirm('Are you sure you want to remove this subscriber?')">
                                            Remove Subscriber
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-4 bg-white px-4 py-3 rounded-lg shadow">
                {{ $subscribers->links() }}
            </div>
        @endif
    </div>
@endsection
