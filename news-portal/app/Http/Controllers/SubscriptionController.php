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
        // $this->middleware('role:admin|user', ['only' => ['subscribe', 'unsubscribe']]);
    }

    // List all subscriptions (admin only)
    // public function index()
    // {
    //     $subscriptions = Subscription::with(['user', 'publisher'])->paginate(10);
    //     return view('subscriptions.index', compact('subscriptions'));
    // }

    // In SubscriptionController
    public function removeSubscriber(Request $request, User $subscriber)
    {
        $publisher = auth()->user(); // Current user is the publisher

        $subscription = Subscription::where('user_id', $subscriber->id)
            ->where('publisher_id', $publisher->id)
            ->where('status', 'active')
            ->where(function ($query) {
                $query->whereNull('expires_at')
                    ->orWhere('expires_at', '>=', now());
            })
            ->first();

        if ($subscription) {
            $subscription->update([
                'status' => 'cancelled',
                'expires_at' => now(),
            ]);

            return redirect()->back()->with('success', 'Subscriber removed successfully!');
        }

        return redirect()->back()->with('error', 'No active subscription found for this user.');
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
            ->where('status', 'active') // ✅ Only target active subscriptions
            ->where(function ($query) {
                $query->whereNull('expires_at')
                    ->orWhere('expires_at', '>=', now()); // ✅ Not already expired
            })
            ->first();

        if ($subscription) {
            $subscription->update([
                'status' => 'cancelled',
                'expires_at' => now(), // Optional: expire immediately
            ]);

            return redirect()->back()->with('success', 'Unsubscribed successfully!');
        }

        return redirect()->back()->with('error', 'No active subscription found.');
    }

    public function index()
    {
        $user = auth()->user();

        if ($user->hasRole('publisher')) {

            $subscribers = $user->subscribers()
                ->with(['user' => function ($query) {
                    $query->select('id', 'name', 'email');
                }])
                ->latest()
                ->paginate(10);

            $newThisMonthCount = $user->subscribers()
                ->where('created_at', '>=', now()->startOfMonth())
                ->count();

            return view('publisher.subscribers', [
                'subscribers' => $subscribers,
                'newThisMonthCount' => $newThisMonthCount
            ]);
        }

        if ($user->hasRole('admin')) {
            $publishers = User::role('publisher')
                ->withCount(['subscribers as active_subscribers_count' => function ($query) {
                    $query->where('status', 'active')
                        ->where(function ($q) {
                            $q->whereNull('expires_at')
                                ->orWhere('expires_at', '>=', now());
                        });
                }])
                ->orderBy('active_subscribers_count', 'desc')
                ->paginate(10);

            return view('admin.list', compact('publishers'));
        }

        abort(403, 'Unauthorized action.');
    }
}
