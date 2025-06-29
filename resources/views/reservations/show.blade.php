@extends('layouts.app')


@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-lg border-0 modern-form-card" style="border-radius: 22px;">
                <div class="card-header bg-primary text-white" style="border-radius: 22px 22px 0 0;">
                    <h2 class="mb-0">Reservation #{{ $reservation->id }}</h2>
                </div>
                <div class="card-body">
                    <div class="row g-4">
                        <!-- Car Details -->
                        <div class="col-md-6">
                            <h5 class="mb-3 text-primary">Car Details</h5>
                            @if($reservation->car->image)
                                <img src="{{ asset('storage/' . $reservation->car->image) }}" alt="{{ $reservation->car->name }}"
                                    class="img-fluid rounded mb-3 shadow-sm" style="max-height: 180px; object-fit: cover;">
                            @endif
                            <ul class="list-group list-group-flush mb-3">
                                <li class="list-group-item"><strong>Name:</strong> {{ $reservation->car->name }}</li>
                                <li class="list-group-item"><strong>Color:</strong> {{ $reservation->car->color }}</li>
                                <li class="list-group-item"><strong>Year:</strong> {{ $reservation->car->year }}</li>
                                <li class="list-group-item"><strong>Owner:</strong> {{ $reservation->car->createdBy->name ?? '-' }}</li>
                            </ul>
                        </div>
                        <!-- User Details -->
                        <div class="col-md-6">
                            <h5 class="mb-3 text-success">User Details</h5>
                            <ul class="list-group list-group-flush mb-3">
                                <li class="list-group-item"><strong>Name:</strong> {{ $reservation->user->name }}</li>
                                <li class="list-group-item"><strong>Email:</strong> {{ $reservation->user->email }}</li>
                                <li class="list-group-item"><strong>Paying by:</strong> {{ ucfirst($reservation->user->payment_method) }}</li>
                                <li class="list-group-item"><strong>Address:</strong> {{ $reservation->user->address }}</li>
                            </ul>
                            <h6 class="mt-4 mb-2 text-secondary">Reservation Info</h6>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item"><strong>Date:</strong> {{ \Carbon\Carbon::parse($reservation->reservation_date)->format('Y-m-d H:i') }}</li>
                                <li class="list-group-item">
                                    <strong>Status:</strong>
                                    <span class="badge bg-{{ $reservation->state->value === 'canceled' ? 'danger' : ($reservation->state->value === 'completed' ? 'success' : 'info') }}">
                                        {{ ucfirst($reservation->state->value) }}
                                    </span>
                                </li>
                            </ul>
                        </div>
                    </div>
                    @if(auth()->check() && $reservation->car->created_by_id == auth()->id())
                        <div class="mt-4 text-center">
                            <a href="mailto:{{ $reservation->user->email }}?subject=Regarding your car reservation&body=Hello {{ $reservation->user->name }},%0D%0A%0D%0AI am contacting you regarding your reservation for the car '{{ $reservation->car->name }}' (Reservation ID: {{ $reservation->id }}). My place is in: {{$reservation->user->address}} Please let me know if you have any questions.%0D%0A%0D%0AThank you."
                                class="btn btn-success">
                                📧 Contact {{ $reservation->user->name }}
                            </a>
                        </div>
                    @endif
                </div>
            </div>
            <div class="mt-4 text-center">
                <a href="{{ route('reservations.index') }}" class="btn btn-secondary">Back to Reservations List</a>
            </div>
        </div>
    </div>
    <style>
        .modern-form-card {
            background: linear-gradient(120deg, #f8fafc 80%, #e0f7fa 100%);
            border-radius: 22px;
            box-shadow: 0 8px 32px rgba(75,139,145,0.10), 0 2px 8px rgba(0,0,0,0.04);
            margin-bottom: 32px;
        }
        .modern-form-card .card-header {
            font-weight: 600;
            font-size: 1.2rem;
            background: linear-gradient(90deg, #4b8b91 60%, #2196F3 100%) !important;
            color: #fff !important;
            border: none;
        }
        .list-group-item {
            background: transparent;
            border: none;
            padding-left: 0;
            padding-right: 0;
        }
        .badge {
            font-size: 1rem;
            font-weight: 500;
        }
    </style>
</div>
@endsection
