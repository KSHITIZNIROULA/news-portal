<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Subscription;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin|user', ['only' => ['subscribe', 'unsubscribe']]);
        $this->middleware('role:admin', ['only' => ['index']]);
    }

    // List all subscriptions (admin only)
    public function index()
    {
        $subscriptions = Subscription::with(['user', 'publisher'])->paginate(10);
        return view('subscriptions.index', compact('subscriptions'));
    }

    // Subscribe to a publisher
    public function subscribe(Request $request, User $publisher)
    {
        $user = auth()->user();
        if ($user->hasRole('publisher') && $user->id === $publisher->id) {
            return redirect()->back()->with('error', 'You cannot subscribe to yourself.');
        }

        if (!$publisher->hasRole('publisher')) {
            return redirect()->back()->with('error', 'Invalid publisher.');
        }

        if ($user->isSubscribedTo($publisher)) {
            return redirect()->back()->with('error', 'You are already subscribed to this publisher.');
        }

        Subscription::create([
            'user_id' => $user->id,
            'publisher_id' => $publisher->id,
            'subscribed_at' => now(),
            'expires_at' => now()->addMonth(), // Example: 1-month subscription
            'status' => 'active',
        ]);

        return redirect()->back()->with('success', 'Subscribed successfully!');
    }

    // Unsubscribe from a publisher
    public function unsubscribe(Request $request, User $publisher)
    {
        $user = auth()->user();
        $subscription = Subscription::where('user_id', $user->id)
            ->where('publisher_id', $publisher->id)
            ->first();

        if ($subscription) {
            $subscription->update(['status' => 'cancelled']);
            return redirect()->back()->with('success', 'Unsubscribed successfully!');
        }

        return redirect()->back()->with('error', 'No active subscription found.');
    }
}