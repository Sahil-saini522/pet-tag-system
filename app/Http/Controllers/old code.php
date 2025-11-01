<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tag;
use App\Models\Membership;
use App\Models\ScanLog;
use Carbon\Carbon;

class DashboardController extends Controller
{
    // Dashboard page
   public function index()
{
    $user = auth()->user();

    $tags = \App\Models\Tag::where('user_id', $user->id)->get();

    $membership = \App\Models\Membership::where('user_id', $user->id)
        ->latest('starts_at')
        ->first();

    if (!$membership || !$membership->isActive()) {
        return redirect()->route('membership.buy')
            ->with('error', 'Please purchase membership before activating a tag.');
    }

    // ✅ Per-Tag Scan Stats (last 7 days)
    $scanCounts = \App\Models\ScanLog::selectRaw('tag_id, COUNT(*) as total')
        ->whereIn('tag_id', $tags->pluck('id'))
        ->where('created_at', '>=', now()->subDays(7))
        ->groupBy('tag_id')
        ->pluck('total', 'tag_id');

    // Prepare chart data
    $chartLabels = $tags->pluck('tag_code');
    $chartData = $tags->map(fn($t) => $scanCounts[$t->id] ?? 0);

    return view('dashboard', compact('tags', 'membership', 'chartLabels', 'chartData'));
}

    // Membership purchase page
    public function buyMembership()
    {
        return view('membership.buy'); // Blade view
    }

    // Store membership
    public function storeMembership(Request $request)
    {
        $user = auth()->user();

        Membership::create([
            'user_id' => $user->id,
            'starts_at' => now(),
            'expires_at' => now()->addYear(),
            'stripe_payment_id' => null, // for simulation
        ]);

        return redirect()->route('dashboard')->with('success', 'Membership activated successfully!');
    }
}
