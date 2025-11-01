<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pet;
use App\Models\Tag;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PetController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // List all pets for the logged-in user
    public function index()
    {
        $pets = Pet::where('user_id', Auth::id())->get();
        return view('pets.index', compact('pets'));
    }

    // Show form to create new pet
    public function create()
    {
        // Only show tags that are owned by user and not linked yet
        $tags = Tag::where('user_id', Auth::id())->whereNull('pet_id')->get();
        return view('pets.create', compact('tags'));
    }

    // Store pet in database
   public function store(Request $request, Tag $tag)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'breed' => 'nullable|string|max:255',
        'photo' => 'nullable|image|max:2048',
        'owner_name' => 'required|string|max:255',
        'contact_email' => 'required|email|max:255',
        'contact_phone' => 'nullable|string|max:20',
        'address' => 'nullable|string|max:500',
        'emergency_contact' => 'nullable|string|max:255',
        'medical_info' => 'nullable|string',
    ]);

    $data = $request->all();
    $data['user_id'] = Auth::id();
    $data['tag_id'] = $tag->id;

    // handle photo
    if ($request->hasFile('photo')) {
        $data['photo'] = $request->file('photo')->store('pets', 'public');
    }

    // create pet
    $pet = Pet::create($data);

    // link tag to pet
    $tag->pet_id = $pet->id;
    $tag->save();

    return redirect()->route('pets.index')->with('success', 'Pet added successfully!');
}


    

    // Show single pet
    public function show(Pet $pet)
    {
        $this->authorize('view', $pet); // Optional: use policies
        return view('pets.show', compact('pet'));
    }

    // Edit pet
    public function edit(Pet $pet)
    {
        $this->authorize('update', $pet); // Optional: use policies
        $tags = Tag::where('user_id', Auth::id())->get();
        return view('pets.edit', compact('pet', 'tags'));
    }

    // Update pet
    public function update(Request $request, Pet $pet)
    {
        $this->authorize('update', $pet);

        $request->validate([
            'name' => 'required|string|max:255',
            'breed' => 'nullable|string|max:255',
            'photo' => 'nullable|image|max:2048',
            'medical_info' => 'nullable|string',
            'address' => 'nullable|string|max:500',
            'emergency_contact' => 'nullable|string|max:255',
            'tag_id' => 'required|exists:tags,id',
        ]);

        $data = $request->all();

        if ($request->hasFile('photo')) {
            // Delete old photo if exists
            if ($pet->photo) {
                Storage::disk('public')->delete($pet->photo);
            }
            $path = $request->file('photo')->store('pets', 'public');
            $data['photo'] = $path;
        }

        $pet->update($data);

        // Update tag linkage
        if ($pet->tag_id != $request->tag_id) {
            $oldTag = Tag::find($pet->tag_id);
            if ($oldTag) $oldTag->pet_id = null;

            $newTag = Tag::find($request->tag_id);
            $newTag->pet_id = $pet->id;

            $oldTag?->save();
            $newTag->save();
        }

        return redirect()->route('pets.index')->with('success', 'Pet updated successfully!');
    }

    // Delete pet
    public function destroy(Pet $pet)
    {
        $this->authorize('delete', $pet);

        // Delete photo if exists
        if ($pet->photo) {
            Storage::disk('public')->delete($pet->photo);
        }

        // Unlink tag
        if ($pet->tag) {
            $pet->tag->pet_id = null;
            $pet->tag->save();
        }

        $pet->delete();

        return redirect()->route('pets.index')->with('success', 'Pet deleted successfully!');
    }
}
