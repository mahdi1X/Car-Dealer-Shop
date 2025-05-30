@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <h2>Admin Report Details</h2>

        <div class="card mt-3">
            <div class="card-header">
                Submitted by Manager: {{ $adminReport->manager->name }}
            </div>
            <div class="card-body">
                <a href="{{ route('user.profile', $adminReport->report->reportedUser->id) }}">
                    <p><strong>Reported User:</strong> {{ $adminReport->report->reportedUser->name }}
                        ({{ $adminReport->report->reportedUser->region }})
                    </p>
                </a>
                <a href="{{ route('user.profile', $adminReport->report->reporterUser->id) }}">
                    <p><strong>Reporter:</strong> {{ $adminReport->report->reporterUser->name }}
                        ({{ $adminReport->report->reporterUser->region }})</p>
                </a>
                <p><strong>Reason:</strong> {{ $adminReport->report->reason }}</p>
                <p><strong>Manager Note:</strong> {{ $adminReport->manager_note }}</p>

                {{-- Add View Original Report button --}}
                <a href="{{ route('reports.show', $adminReport->report->id) }}" class="btn btn-primary mt-3">
                    View Original Report
                </a>

                <p class="mt-3"><strong>Submitted At:</strong> {{ $adminReport->created_at->format('F j, Y h:i A') }}</p>
            </div>
        </div>

        <a href="{{ route('reports.index') }}" class="btn btn-secondary mt-3">Back to All Reports</a>
    </div>
@endsection
