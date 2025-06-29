@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <h2 class="mb-4">Admin Report Details</h2>
        <div class="card mt-3 shadow border-0 modern-admin-report-card" style="border-radius: 18px;">
            <div class="card-header bg-primary text-white" style="border-radius: 18px 18px 0 0;">
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
                <a href="{{ route('reports.show', $adminReport->report->id) }}" class="btn btn-outline-primary btn-sm mt-3">
                    View Original Report
                </a>
                <p class="mt-3"><strong>Submitted At:</strong> {{ $adminReport->created_at->format('F j, Y h:i A') }}</p>
            </div>
        </div>
        <a href="{{ route('reports.index') }}" class="btn btn-secondary mt-3">Back to All Reports</a>
        <style>
            .modern-admin-report-card {
                background: linear-gradient(120deg, #f8fafc 80%, #e0f7fa 100%);
                border-radius: 18px;
                box-shadow: 0 8px 32px rgba(75,139,145,0.10), 0 2px 8px rgba(0,0,0,0.04);
                transition: box-shadow 0.2s, transform 0.2s;
            }
            .modern-admin-report-card:hover {
                box-shadow: 0 12px 48px rgba(75,139,145,0.18), 0 4px 16px rgba(0,0,0,0.10);
                transform: translateY(-4px) scale(1.01);
            }
            .modern-admin-report-card .card-header {
                font-weight: 600;
                font-size: 1.1rem;
                background: linear-gradient(90deg, #4b8b91 60%, #2196F3 100%) !important;
                color: #fff !important;
                border: none;
            }
            .modern-admin-report-card .card-body h5 {
                color: #4b8b91;
                font-weight: 700;
            }
        </style>
    </div>
@endsection
