<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subscription;
use App\Models\User;
use App\Services\Esewa;
use Illuminate\Support\Facades\Auth;

class EsewaController extends Controller
{
    public function initiate(User $publisher)
    {
        $amount = 600; // Example static amount — change to dynamic if needed
        $user = Auth::user();
        $purchase_order_id = uniqid('sub_');
        $purchase_order_name = "Subscription to publisher: {$publisher->name}";
        $return_url = route('esewa.verification', ['publisher' => $publisher->id]);

        // Save necessary info in session
        session([
            'esewa_txn_id' => $purchase_order_id,
            'publisher_id' => $publisher->id,
            'amount' => $amount,
        ]);

        $esewa = new Esewa();
        return $esewa->pay($amount, $return_url, $purchase_order_id, $purchase_order_name);
    }

    public function verification(Request $request, $publisherId)
    {
        $esewa = new Esewa();

        $decodedString = base64_decode($request->input('data'));
        $data = json_decode($decodedString, true);

        $transaction_uuid = $data['transaction_uuid'] ?? null;

        $amount = session('amount');
        $storedPublisherId = session('publisher_id');

        // Safety check
        if (!$transaction_uuid || !$amount || !$storedPublisherId || $publisherId != $storedPublisherId) {
            return redirect()->route('subscriptions.index')->with('error', 'Invalid session or payment data.');
        }

        // Verify payment with Esewa
        $inquiry = $esewa->inquiry($transaction_uuid, ['total_amount' => $amount]);

        if ($esewa->isSuccess($inquiry)) {
            // Create or renew subscription
            Subscription::updateOrCreate(
                [
                    'user_id' => auth()->id(),
                    'publisher_id' => $publisherId,
                ],
                [
                    'subscribed_at' => now(),
                    'expires_at' => now()->addMonth(),
                    'status' => 'active',
                ]
            );

            // Clear session
            session()->forget(['esewa_txn_id', 'publisher_id', 'amount']);

            return redirect()->route('foryou')->with('success', 'Subscription activated!');
        }

        return redirect()->route('subscriptions.index')->with('error', 'Payment verification failed.');
    }

    public function failure()
    {
        return redirect()->route('subscriptions.index')->with('error', 'Payment was cancelled or failed.');
    }
}