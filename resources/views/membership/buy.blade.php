@extends('layouts.app')

@section('content')
<style>
    body {
        background: linear-gradient(135deg, #f5f7fa, #c3cfe2);
    }

    .membership-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 60px 20px;
        text-align: center;
    }

    .membership-title {
        font-size: 2.2rem;
        font-weight: 700;
        margin-bottom: 10px;
        color: #333;
    }

    .membership-subtitle {
        color: #555;
        margin-bottom: 50px;
    }

    .membership-cards {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 25px;
    }

    .membership-card {
        background: #fff;
        border-radius: 15px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        padding: 30px 20px;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .membership-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.15);
    }

    .membership-card.active {
        border: 3px solid #007bff;
    }

    .membership-card.coming-soon::after {
        content: "Coming Soon";
        position: absolute;
        top: 10px;
        right: -45px;
        background: #ff9800;
        color: #fff;
        transform: rotate(45deg);
        padding: 5px 40px;
        font-size: 0.8rem;
        font-weight: bold;
    }

    .plan-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: #222;
        margin-bottom: 15px;
    }

    .plan-price {
        font-size: 1.8rem;
        font-weight: 700;
        color: #007bff;
        margin-bottom: 20px;
    }

    .plan-features {
        list-style: none;
        padding: 0;
        text-align: left;
        margin-bottom: 30px;
    }

    .plan-features li {
        margin: 8px 0;
        display: flex;
        align-items: center;
        font-size: 0.95rem;
        color: #444;
    }

    .plan-features li i {
        color: #28a745;
        margin-right: 10px;
        font-size: 1rem;
    }

    .btn-pay {
        background: #007bff;
        color: #fff;
        padding: 12px 30px;
        border-radius: 30px;
        font-size: 1rem;
        border: none;
        transition: all 0.3s;
    }

    .btn-pay:hover {
        background: #0056b3;
        transform: scale(1.05);
    }
</style>

<div class="membership-container">
    <h1 class="membership-title">Choose Your Membership Plan</h1>
    <p class="membership-subtitle">Unlock full access to your Pet Tag Dashboard and exclusive features.</p>

    <div class="membership-cards">
        {{-- Yearly Plan (Active) --}}
        <div class="membership-card active">
            <h2 class="plan-title">1-Year Membership</h2>
            <p class="plan-price">$50 / Year</p>
            <ul class="plan-features">
                <li><i class="fas fa-check-circle"></i> Create up to 20 pet tags</li>
                <li><i class="fas fa-check-circle"></i> Manage pet & owner profiles</li>
                <li><i class="fas fa-check-circle"></i> Tag activation & QR/NFC linking</li>
                <li><i class="fas fa-check-circle"></i> Lost pet recovery support</li>
                <li><i class="fas fa-check-circle"></i> Secure dashboard access</li>
            </ul>
            <form action="{{ route('membership.create') }}" method="POST">
                @csrf
                <button type="submit" class="btn-pay">Pay $50 (Apple Pay / Stripe)</button>
            </form>
        </div>

        {{-- 6-Month Plan --}}
        <div class="membership-card coming-soon">
            <h2 class="plan-title">6-Month Membership</h2>
            <p class="plan-price">$30 / 6 Months</p>
            <ul class="plan-features">
                <li><i class="fas fa-check-circle"></i> Access to pet management tools</li>
                <li><i class="fas fa-check-circle"></i> Tag activation (limited slots)</li>
                <li><i class="fas fa-check-circle"></i> Dashboard & support</li>
            </ul>
            <button class="btn-pay" disabled>Coming Soon</button>
        </div>

        {{-- Monthly Plan --}}
        <div class="membership-card coming-soon">
            <h2 class="plan-title">Monthly Membership</h2>
            <p class="plan-price">$10 / Month</p>
            <ul class="plan-features">
                <li><i class="fas fa-check-circle"></i> Manage up to 5 pets</li>
                <li><i class="fas fa-check-circle"></i> Basic dashboard access</li>
                <li><i class="fas fa-check-circle"></i> Support included</li>
            </ul>
            <button class="btn-pay" disabled>Coming Soon</button>
        </div>
    </div>
</div>

{{-- Font Awesome for check icons --}}
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
@include('components.footer')
@endsection
