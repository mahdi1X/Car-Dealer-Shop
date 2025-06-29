@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="mb-4">Report #{{ $report->id }}</h2>
        <div class="card mt-4 shadow border-0 modern-report-card" style="border-radius: 18px;">
            <div class="card-body">
                <div class="row g-4 align-items-center">
                    <div class="col-md-6">
                        <div class="d-flex align-items-center mb-3">
                            <span class="avatar bg-primary text-white rounded-circle me-3"
                                style="width:48px;height:48px;display:flex;align-items:center;justify-content:center;font-size:1.5rem;">
                                {{ strtoupper(substr($report->reportedUser->name, 0, 1)) }}
                            </span>
                            <div>
                                <a href="{{ route('user.profile', $report->reportedUser->id) }}" class="text-decoration-none">
                                    <strong>Reported User:</strong>
                                    <span style="color:#4b8b91;">{{ $report->reportedUser->name }}</span>
                                    <span class="badge bg-light text-dark ms-2">{{ $report->reportedUser->region }}</span>
                                </a>
                            </div>
                        </div>
                        <div class="d-flex align-items-center mb-3">
                            <span class="avatar bg-secondary text-white rounded-circle me-3"
                                style="width:48px;height:48px;display:flex;align-items:center;justify-content:center;font-size:1.5rem;">
                                {{ strtoupper(substr($report->reporterUser->name, 0, 1)) }}
                            </span>
                            <div>
                                <a href="{{ route('user.profile', $report->reporterUser->id) }}" class="text-decoration-none">
                                    <strong>Reporter:</strong>
                                    <span style="color:#2196F3;">{{ $report->reporterUser->name }}</span>
                                    <span class="badge bg-light text-dark ms-2">{{ $report->reporterUser->region }}</span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <p class="mb-2"><strong>Reason:</strong></p>
                        <div class="alert alert-info p-3" style="font-size:1.08rem;">
                            {{ $report->reason }}
                        </div>
                        <p class="mb-1"><strong>Submitted At:</strong> {{ $report->created_at->format('F j, Y h:i A') }}</p>
                    </div>
                </div>
                <div class="mt-4 text-end">
                    <a href="{{ route('reports.index') }}" class="btn btn-secondary">Back to Reports</a>
                </div>
            </div>
        </div>
        <style>
            .modern-report-card {
                background: linear-gradient(120deg, #f8fafc 80%, #e0f7fa 100%);
                border-radius: 18px;
                box-shadow: 0 8px 32px rgba(75,139,145,0.10), 0 2px 8px rgba(0,0,0,0.04);
            }
            .avatar {
                font-size: 1.1rem;
                font-weight: 700;
                width: 48px;
                height: 48px;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                border-radius: 50%;
                background: #4b8b91;
            }
            .badge {
                font-size: 0.95rem;
                font-weight: 500;
            }
        </style>
    </div>
@endsection
