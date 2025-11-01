@extends('layouts.app')

@section('content')
<div class="container text-center py-5">
    <h1 class="mb-4">Buy 1-Year Membership</h1>

    <p class="mb-3">Access all features for 12 months — including tag activation and pet management.</p>

    <form action="{{ route('membership.create') }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-primary btn-lg">
            Pay $50 (via Stripe / Apple Pay)
        </button>
    </form>
</div>
@endsection
