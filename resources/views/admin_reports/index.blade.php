@extends('layouts.app')

@section('content')
    <div class="container">
        <br><br>
        <h2 class="mb-4">Admin Reports</h2>
        <br>
        @foreach ($reports as $adminReport)
            <div class="card mb-3">
                <div class="card-header">
                    Submitted by Manager: {{ $adminReport->manager->name }}
                </div>
                <div class="card-body">
                    <h5>Reported User: {{ $adminReport->report->reportedUser->name }}</h5>
                    <p>Original Reason: {{ $adminReport->report->reason }}</p>
                    <p>Manager Note: {{ $adminReport->manager_note }}</p>

                    <a href="{{ route('admin-reports.show', $adminReport->id) }}" class="btn btn-primary btn-sm mt-2">
                        View Full Report
                    </a>
                </div>
            </div>
            <br>
        @endforeach
    </div>
@endsection
