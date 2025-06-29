@extends('layouts.app')

@section('content')
    <div class="container">
        <br><br>
        <h2 class="mb-4">Admin Reports</h2>
        <br>
        <div class="row row-cols-1 row-cols-md-2 g-4">
            @foreach ($reports as $adminReport)
                <div class="col d-flex">
                    <div class="card mb-3 flex-fill shadow border-0 modern-admin-report-card" style="border-radius: 18px;">
                        <div class="card-header bg-primary text-white" style="border-radius: 18px 18px 0 0;">
                            Submitted by Manager: {{ $adminReport->manager->name }}
                        </div>
                        <div class="card-body">
                            <h5 class="mb-2"><strong>Reported User:</strong> {{ $adminReport->report->reportedUser->name }}</h5>
                            <p class="mb-1"><strong>Original Reason:</strong> {{ $adminReport->report->reason }}</p>
                            <p class="mb-2"><strong>Manager Note:</strong> {{ $adminReport->manager_note }}</p>
                            <a href="{{ route('admin-reports.show', $adminReport->id) }}" class="btn btn-outline-primary btn-sm mt-2">
                                View Full Report
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
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
