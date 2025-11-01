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

        // Fetch tags belonging to this user
        $tags = Tag::where('user_id', $user->id)->get();

        // Get latest membership
        $membership = Membership::where('user_id', $user->id)
                                ->latest('starts_at')
                                ->first();

        // If no membership or membership expired, redirect to buy page
        if (!$membership || !$membership->isActive()) {
            return redirect()->route('membership.buy')
                             ->with('error', 'Please purchase membership before activating a tag.');
        }

        // ✅ Get Scan Log Stats (Last 7 Days)
        $scanStats = ScanLog::whereIn('tag_id', $tags->pluck('id'))
            ->where('created_at', '>=', now()->subDays(7))
            ->selectRaw('DATE(created_at) as date, COUNT(*) as total')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Format for chart (x: labels, y: values)
        $chartLabels = $scanStats->pluck('date')->map(fn($d) => Carbon::parse($d)->format('d M'));
        $chartData = $scanStats->pluck('total');

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
