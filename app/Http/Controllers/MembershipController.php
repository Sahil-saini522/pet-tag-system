<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Membership;
use Stripe\Stripe;
use Stripe\Checkout\Session as CheckoutSession;

class MembershipController extends Controller
{
    public function buy()
    {
        return view('membership.buy');
    }

    public function createCheckoutSession(Request $request)
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        $checkout = CheckoutSession::create([
            'payment_method_types' => ['card', 'apple_pay', 'google_pay'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => '1-Year Membership',
                    ],
                    'unit_amount' => 999, // $9.99 in cents
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => route('membership.success'),
            'cancel_url' => route('membership.cancel'),
        ]);

        return redirect($checkout->url);
    }

    public function success()
    {
        $user = auth()->user();

        Membership::create([
            'user_id' => $user->id,
            'starts_at' => now(),
            'expires_at' => now()->addYear(),
        ]);

        return redirect()->route('dashboard')->with('success', 'Membership activated successfully!');
    }

    public function cancel()
    {
        return redirect()->route('dashboard')->with('error', 'Payment was cancelled.');
    }
}
