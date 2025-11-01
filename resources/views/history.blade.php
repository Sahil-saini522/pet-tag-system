@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h1 class="text-center mb-4">📊 Scan History for Tag: <span class="text-primary">{{ $tag->tag_code }}</span></h1>

    @if($logs->count())
        <div class="table-responsive">
            <table class="table table-striped shadow-sm">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>IP Address</th>
                        <th>User Agent</th>
                        <th>Scanned At</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($logs as $index => $log)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $log->ip }}</td>
                            <td>{{ Str::limit($log->user_agent, 40) }}</td>
                            <td>{{ $log->created_at->format('d M Y, h:i A') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="alert alert-info text-center mt-5">
            No scans recorded yet for this tag.
        </div>
    @endif

    <div class="text-center mt-4">
        <a href="{{ url('/tag/' . $tag->tag_code) }}" class="btn btn-secondary">🔙 Back to Pet Info</a>
    </div>
</div>
@endsection
