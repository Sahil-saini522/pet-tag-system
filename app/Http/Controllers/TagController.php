<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tag;
use App\Models\Pet;
use App\Models\Membership;

class TagController extends Controller
{
    // Activate tag (only for users with active membership)

    // Activate tag (auto-create if not exists)
    public function activate(Request $request)
    {
        $request->validate([
            'tag_code' => 'required|string|max:255',
        ]);

        $user = auth()->user();

        // Check latest membership
        $membership = Membership::where('user_id', $user->id)
                                ->latest('starts_at')
                                ->first();

        if (!$membership || !$membership->isActive()) {
            return back()->with('error', 'Please purchase membership before activating a tag.');
        }

        // Find or create tag
        $tag = Tag::firstOrCreate(
            ['tag_code' => $request->tag_code], // if tag_code exists, return it
            ['user_id' => $user->id, 'active' => true] // if not, create new
        );

        // Assign user and mark active (just in case it existed but inactive)
        $tag->user_id = $user->id;
        $tag->active = true;
        $tag->save();

        return back()->with('success', 'Tag activated successfully!');
    }

    // Public scan page
    public function publicView($tag_code)
    {
        $tag = Tag::where('tag_code', $tag_code)->first();

        if (!$tag) {
            abort(404);
        }

        return view('tags.public', compact('tag'));
    }
    // Show pet form for a tag
public function managePet($tag_id)
{
    $tag = Tag::where('id', $tag_id)
              ->where('user_id', auth()->id())
              ->firstOrFail();

    return view('tags.manage_pet', compact('tag'));
}

// Store pet info
public function storePet(Request $request, $tag_id)
{
    $tag = Tag::where('id', $tag_id)
              ->where('user_id', auth()->id())
              ->firstOrFail();

    $request->validate([
        'pet_name' => 'required|string|max:255',
        'breed' => 'nullable|string|max:255',
        'photo' => 'nullable|image|max:2048',
        'owner_name' => 'required|string|max:255',
        'contact_email' => 'required|email',
        'contact_phone' => 'nullable|string|max:20',
        'address' => 'nullable|string|max:500',
        'medical_info' => 'nullable|string|max:1000',
    ]);

    $pet = $tag->pet ?? new \App\Models\Pet();

    // ✅ FIXED: assign user id
    $pet->user_id = auth()->id();

    $pet->name = $request->pet_name;
    $pet->breed = $request->breed;
    $pet->owner_name = $request->owner_name;
    $pet->contact_email = $request->contact_email;
    $pet->contact_phone = $request->contact_phone;
    $pet->address = $request->address;
    $pet->medical_info = $request->medical_info;

    // Upload photo if exists
    if ($request->hasFile('photo')) {
        $pet->photo = $request->file('photo')->store('pets', 'public');
    }

    $pet->save();

    // Link pet to tag
    $tag->pet_id = $pet->id;
    $tag->save();

    return redirect()->route('dashboard')->with('success', 'Pet info saved successfully!');
}




}




