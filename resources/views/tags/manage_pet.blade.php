@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Manage Pet for Tag: {{ $tag->tag_code }}</h1>

<form action="{{ route('tags.storePet', $tag->id) }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div>
            <label>Pet Name</label>
            <input type="text" name="pet_name" value="{{ $tag->pet->name ?? '' }}" required>
        </div>

        <div>
            <label>Breed</label>
            <input type="text" name="breed" value="{{ $tag->pet->breed ?? '' }}">
        </div>

        <div>
            <label>Photo</label>
            <input type="file" name="photo">
        </div>

        <div>
            <label>Owner Name</label>
            <input type="text" name="owner_name" value="{{ $tag->pet->owner_name ?? '' }}" required>
        </div>

        <div>
            <label>Contact Email</label>
            <input type="email" name="contact_email" value="{{ $tag->pet->contact_email ?? '' }}" required>
        </div>

        <div>
            <label>Contact Phone</label>
            <input type="text" name="contact_phone" value="{{ $tag->pet->contact_phone ?? '' }}">
        </div>

        <div>
            <label>Address</label>
            <textarea name="address">{{ $tag->pet->address ?? '' }}</textarea>
        </div>

        <div>
            <label>Medical Info / Emergency Contact</label>
            <textarea name="medical_info">{{ $tag->pet->medical_info ?? '' }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Save Pet Info</button>
    </form>
</div>
@endsection
