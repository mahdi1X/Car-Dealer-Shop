@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Report #{{ $report->id }}</h2>

        <div class="card mt-4">
            <div class="card-body">
                <a href="{{ route('user.profile', $report->reportedUser->id) }}">
                    <p><strong>Reported User:</strong> {{ $report->reportedUser->name }}
                        ({{ $report->reportedUser->region }})
                    </p>
                </a>
                <a href="{{ route('user.profile', $report->reporterUser->id) }}">
                    <p><strong>Reporter:</strong> {{ $report->reporterUser->name }}
                        ({{ $report->reporterUser->region }})</p>

                </a>
                <p><strong>Reason:</strong></p>
                <p>{{ $report->reason }}</p>
                <p><strong>Submitted At:</strong> {{ $report->created_at->format('F j, Y h:i A') }}</p>


                <a href="{{ route('reports.index') }}" class="btn btn-secondary mt-3">Back to Reports</a>
            </div>
        </div>
    </div>
@endsection
