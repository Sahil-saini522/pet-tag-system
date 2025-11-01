@extends('layouts.app')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

@section('content')
<div class="container py-4" x-data="{ showForm: false, showAlert: true }">

    {{-- ✅ Flash Messages --}}
    @if(session('success'))
        <div x-show="showAlert" x-transition
             class="alert alert-success"
             x-init="setTimeout(() => showAlert = false, 4000)">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div x-show="showAlert" x-transition
             class="alert alert-danger"
             x-init="setTimeout(() => showAlert = false, 4000)">
            {{ session('error') }}
        </div>
    @endif

    {{-- ✅ Header --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>🐾 My Pet Tags</h1>

        @php
            $membership = auth()->user()->membership ?? null;
        @endphp

        @if(!$membership || !$membership->isActive())
            <a href="{{ route('membership.buy') }}" class="btn btn-warning">Buy Membership</a>
        @else
            <button class="btn btn-success" @click="showForm = !showForm">
                <span x-text="showForm ? 'Hide Form' : 'Activate New Tag'"></span>
            </button>
        @endif
    </div>

    {{-- ✅ Activate Tag Form --}}
    <div x-show="showForm" x-transition class="card p-3 mb-4 border">
        <h3>Activate a New Tag</h3>
        <form action="{{ route('tags.activate') }}" method="POST">
            @csrf
            <input type="text" name="tag_code" placeholder="Enter tag code" class="form-control mb-2" required>
            <button type="submit" class="btn btn-primary">Activate</button>
        </form>
    </div>

    {{-- ✅ Tags List --}}
    @if($tags->count())
        <div class="row">
            @foreach($tags as $tag)
                <div class="col-md-6 mb-4">
                    <div class="card shadow-sm border-0">
                        <div class="card-body">
                            <h4 class="text-primary">Tag: {{ $tag->tag_code }}</h4>
                            <p>Status: {!! $tag->active ? '✅ Active' : '❌ Inactive' !!}</p>

                            @if($tag->pet)
                                <div class="border p-2 rounded bg-light mb-2">
                                    <p><strong>Pet:</strong> {{ $tag->pet->name }}</p>
                                    <p><strong>Breed:</strong> {{ $tag->pet->breed ?? 'N/A' }}</p>
                                    <p><strong>Owner:</strong> {{ $tag->pet->owner_name ?? 'N/A' }}</p>
                                    <p><strong>Phone:</strong> {{ $tag->pet->contact_phone ?? 'N/A' }}</p>
                                </div>

                                <a href="{{ url('/tag/' . $tag->tag_code) }}" class="btn btn-outline-primary btn-sm">View Public Page</a>
                                <a href="{{ route('tags.managePet', $tag->id) }}" class="btn btn-outline-secondary btn-sm">Edit Pet Info</a>
                            @else
                                <p class="text-danger mb-2">No pet linked to this tag.</p>
                                <a href="{{ route('tags.managePet', $tag->id) }}" class="btn btn-sm btn-warning">Add Pet Info</a>
                            @endif

                            <hr>
                            <h6>Recent Scans:</h6>
                            @if($tag->scanLogs && $tag->scanLogs->count())
                                <ul class="list-unstyled small text-muted">
                                    @foreach($tag->scanLogs->take(5) as $log)
                                        <li>📅 {{ $log->created_at->format('d M Y, h:i A') }} — {{ $log->ip }}</li>
                                    @endforeach
                                </ul>
                            @else
                                <p class="text-muted">No scans recorded yet.</p>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="alert alert-info">You don’t have any tags yet. Activate one above!</div>
    @endif

</div>
<div class="container mt-5">
    <h3 class="mb-3 text-center">📈 Tag-wise Scan Summary (Last 7 Days)</h3>
    <canvas id="tagChart" height="120"></canvas>
</div>

<script>
    const ctxTag = document.getElementById('tagChart');

    new Chart(ctxTag, {
        type: 'bar',
        data: {
            labels: {!! json_encode($chartLabels) !!},
            datasets: [{
                label: 'Total Scans',
                data: {!! json_encode($chartData) !!},
                backgroundColor: [
                    'rgba(255, 99, 132, 0.5)',
                    'rgba(54, 162, 235, 0.5)',
                    'rgba(255, 206, 86, 0.5)',
                    'rgba(75, 192, 192, 0.5)',
                    'rgba(153, 102, 255, 0.5)',
                    'rgba(255, 159, 64, 0.5)'
                ],
                borderColor: 'rgba(0, 0, 0, 0.1)',
                borderWidth: 1,
                borderRadius: 6
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { stepSize: 1 }
                }
            },
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#333',
                    titleColor: '#fff',
                    bodyColor: '#fff'
                }
            }
        }
    });
</script>
 @include('components.footer')
@endsection
 
