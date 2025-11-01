<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session as CheckoutSession;
use App\Models\Membership;

class PaymentController extends Controller
{
    // Show membership purchase page
    public function showMembership()
    {
        return view('membership');
    }

    // Create Stripe checkout session
    public function createSession(Request $request)
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        $user = auth()->user();

        $session = CheckoutSession::create([
            'payment_method_types' => ['card'],
            'mode' => 'payment',
            'line_items' => [[
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => '1 Year Membership',
                    ],
                    'unit_amount' => 5000, // $50.00
                ],
                'quantity' => 1,
            ]],
            'metadata' => [
                'user_id' => $user->id,
            ],
            'success_url' => route('membership.success') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('membership.cancel'),
        ]);

        return redirect($session->url);
    }

    // Success page (called after Stripe payment)
    public function success(Request $request)
    {
        $user = auth()->user();

        // Check if membership already exists
        $existing = Membership::where('user_id', $user->id)
                              ->where('expires_at', '>', now())
                              ->first();

        if (!$existing) {
            Membership::create([
                'user_id' => $user->id,
                'starts_at' => now(),
                'expires_at' => now()->addYear(),
                'stripe_payment_id' => $request->get('session_id'),
            ]);
        }

        return redirect()->route('dashboard')->with('success', '✅ Membership activated successfully!');
    }

    // Cancel page
    public function cancel()
    {
        return redirect()->route('dashboard')->with('error', '❌ Payment was cancelled.');
    }

    // Webhook (optional — can skip for now)
    public function webhook(Request $request)
    {
        return response()->json(['status' => 'ok']);
    }
}
