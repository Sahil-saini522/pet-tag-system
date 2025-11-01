@extends('layouts.guest')

@section('content')
<div class="container text-center py-4">
    <h2>🐾 Lost Pessst</h2>
    <p>Please contact the owner:</p>

    @if($pet)
        @if($pet->photo)
            <img src="{{ asset('storage/' . $pet->photo) }}" 
                 alt="{{ $pet->name }}" 
                 class="img-fluid rounded mb-3" 
                 style="max-width: 300px;">
        @endif

        <h3>{{ $pet->name }}</h3>
        <p><strong>Breed:</strong> {{ $pet->breed ?? 'N/A' }}</p>
        <p><strong>Owner:</strong> {{ $pet->owner_name ?? 'N/A' }}</p>
        <p><strong>Email:</strong> {{ $pet->contact_email ?? 'N/A' }}</p>
        <p><strong>Phone:</strong> {{ $pet->contact_phone ?? 'N/A' }}</p>
        <p><strong>Address:</strong> {{ $pet->address ?? 'N/A' }}</p>
        <p><strong>Emergency Info:</strong> {{ $pet->medical_info ?? 'N/A' }}</p>
    @else
        <p class="text-danger">Owner not available. Please contact site admin.</p>
    @endif
</div>
@endsection
