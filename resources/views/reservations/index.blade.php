@extends('layouts.app')

@section('content')
    <div class="container my-5">
        <h1 class="mb-5 text-center fw-bold" style="letter-spacing:1px;">Reservations Dashboard</h1>
        @if (session('success'))
            <div class="alert alert-success text-center">{{ session('success') }}</div>
        @endif

        <div class="row g-5">
            <!-- My Reservations -->
            <div class="col-lg-6">
                <div class="card shadow-lg border-0 modern-form-card" style="border-radius: 22px;">
                    <div class="card-header bg-primary text-white" style="border-radius: 22px 22px 0 0;">
                        <h4 class="mb-0">My Reservations</h4>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-modern align-middle mb-0">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Car</th>
                                        <th>Owner</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($reservations as $reservation)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                <a href="{{ route('cars.show', $reservation->car->id) }}" class="fw-semibold text-primary">
                                                    {{ $reservation->car->name }}
                                                </a>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <span class="avatar bg-primary text-white rounded-circle me-2"
                                                        style="width:32px;height:32px;display:flex;align-items:center;justify-content:center;">
                                                        {{ strtoupper(substr($reservation->car->createdBy->name ?? '-', 0, 1)) }}
                                                    </span>
                                                    <span>{{ $reservation->car->createdBy->name ?? '-' }}</span>
                                                </div>
                                            </td>
                                            <td>{{ \Carbon\Carbon::parse($reservation->reservation_date)->format('Y-m-d H:i') }}</td>
                                            <td>
                                                <span class="badge bg-{{ $reservation->state->value === 'canceled' ? 'danger' : ($reservation->state->value === 'completed' ? 'success' : 'info') }}">
                                                    {{ ucfirst($reservation->state->value) }}
                                                </span>
                                            </td>
                                            <td>
                                                @if ($reservation->state->value !== 'canceled' && $reservation->state->value !== 'completed')
                                                    <form action="{{ route('reservations.cancel', $reservation->id) }}"
                                                        method="POST" class="d-inline"
                                                        onsubmit="return confirm('Cancel this reservation?')">
                                                        @csrf
                                                        <button type="submit" class="btn btn-outline-danger btn-sm">Cancel</button>
                                                    </form>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center text-muted">No reservations.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Reservations Received -->
            <div class="col-lg-6">
                <div class="card shadow-lg border-0 modern-form-card" style="border-radius: 22px;">
                    <div class="card-header bg-success text-white" style="border-radius: 22px 22px 0 0;">
                        <h4 class="mb-0">Reservations Received</h4>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-modern align-middle mb-0">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Car</th>
                                        <th>By</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($reservations_received as $reservation)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                <a href="{{ route('cars.show', $reservation->car->id) }}" class="fw-semibold text-primary">
                                                    {{ $reservation->car->name }}
                                                </a>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <span class="avatar bg-secondary text-white rounded-circle me-2"
                                                        style="width:32px;height:32px;display:flex;align-items:center;justify-content:center;">
                                                        {{ strtoupper(substr($reservation->user->name, 0, 1)) }}
                                                    </span>
                                                    <span>{{ $reservation->user->name }}</span>
                                                </div>
                                            </td>
                                            <td>{{ \Carbon\Carbon::parse($reservation->reservation_date)->format('Y-m-d H:i') }}</td>
                                            <td>
                                                <span class="badge bg-{{ $reservation->state->value === 'canceled' ? 'danger' : ($reservation->state->value === 'completed' ? 'success' : 'info') }}">
                                                    {{ ucfirst($reservation->state->value) }}
                                                </span>
                                            </td>
                                            <td>
                                                @if ($reservation->state->value === 'pending')
                                                    <a href="{{ route('reservations.view', $reservation->id) }}" class="btn btn-outline-primary btn-sm mb-1">View</a>
                                                @endif
                                                @if ($reservation->state->value !== 'canceled' && $reservation->state->value !== 'completed')
                                                    <form action="{{ route('reservations.complete', $reservation->id) }}"
                                                        method="POST" class="d-inline"
                                                        onsubmit="return confirm('Mark this reservation as completed?')">
                                                        @csrf
                                                        <button type="submit" class="btn btn-outline-success btn-sm">Complete</button>
                                                    </form>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center text-muted">No reservations received.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <style>
            .modern-form-card {
                background: linear-gradient(120deg, #f8fafc 80%, #e0f7fa 100%);
                border-radius: 22px;
                box-shadow: 0 8px 32px rgba(75,139,145,0.10), 0 2px 8px rgba(0,0,0,0.04);
                margin-bottom: 32px;
                width: 100%;
                transition: none;
            }
            .modern-form-card .card-header {
                font-weight: 600;
                font-size: 1.15rem;
                background: linear-gradient(90deg, #4b8b91 60%, #2196F3 100%) !important;
                color: #fff !important;
                border: none;
            }
            .table-modern {
                border-radius: 16px;
                overflow: hidden;
                background: #fff;
                box-shadow: 0 4px 24px rgba(75,139,145,0.08), 0 2px 8px rgba(0,0,0,0.04);
                margin-bottom: 0;
            }
            .table-modern thead th {
                background:wheat
                color: #fff;
                font-weight: 600;
                border: none;
                font-size: 1.08rem;
            }
            .table-modern tbody tr {
                transition: background 0.2s;
            }
            .table-modern tbody tr:hover {
                background: #e0f7fa;
            }
            .table-modern td, .table-modern th {
                border: none;
                vertical-align: middle;
            }
            .avatar {
                font-size: 1.1rem;
                font-weight: 700;
                width: 32px;
                height: 32px;
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

