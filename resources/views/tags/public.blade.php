@extends('layouts.app')

@section('content')
<div class="container text-center py-5">
    <h1 class="mb-4">🐾 Lost Pet Information</h1>

    @if($pet)
        <div class="card mx-auto shadow-lg border-0" style="max-width: 500px; border-radius: 1rem;">
            <div class="card-body">
                {{-- Pet Photo --}}
                @if($pet->photo)
                    <img src="{{ asset('storage/' . $pet->photo) }}" 
                         alt="{{ $pet->name }}" 
                         class="img-fluid rounded mb-3">
                @else
                    <img src="{{ asset('images/default-pet.png') }}" 
                         alt="Pet Photo" 
                         class="img-fluid rounded mb-3">
                @endif

                {{-- Pet Info --}}
                <h3>{{ $pet->name }}</h3>
                <p><strong>Breed:</strong> {{ $pet->breed ?? 'N/A' }}</p>
                <p><strong>Owner Name:</strong> {{ $pet->owner_name ?? 'N/A' }}</p>
                <p><strong>Email:</strong> {{ $pet->contact_email ?? 'N/A' }}</p>
                <p><strong>Phone:</strong> {{ $pet->contact_phone ?? 'N/A' }}</p>
                <p><strong>Address:</strong> {{ $pet->address ?? 'N/A' }}</p>
                <p><strong>Emergency Info:</strong> {{ $pet->medical_info ?? 'N/A' }}</p>

                {{-- Action Buttons --}}
                <div class="mt-4">
                    <a href="{{ url('/') }}" class="btn btn-secondary">🏠 Back to Home</a>
                    <a href="{{ url('/tag/' . $tag->tag_code . '/history') }}" class="btn btn-outline-primary">
                        📊 View Scan History
                    </a>
                </div>
            </div>
        </div>
    @else
        <h3 class="text-danger mt-5">No pet info found for this tag.</h3>
    @endif
</div>
@endsection
