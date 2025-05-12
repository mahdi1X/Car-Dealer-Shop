@extends('layouts.app')

@section('content')
    <div class="container my-5">
        <h1 class="mb-4 text-center">Reservations Dashboard</h1>

        <!-- Success Message -->
        @if (session('success'))
            <div class="alert alert-success text-center">{{ session('success') }}</div>
        @endif

        <div class="row g-4">
            <!-- Section 1: My Reservations -->
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">My Reservations</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover table-sm align-middle mb-0">
                                <thead class="table-light">
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
                                                <a href="{{ route('cars.show', $reservation->car->id) }}">
                                                    {{ $reservation->car->name }}
                                                </a>
                                            </td>
                                            <td>{{ $reservation->car->createdBy->name ?? '-' }}</td>
                                            <td>{{ \Carbon\Carbon::parse($reservation->reservation_date)->format('Y-m-d H:i') }}
                                            </td>
                                            <td>
                                                <span
                                                    class="badge bg-{{ $reservation->state->value === 'canceled' ? 'danger' : 'success' }}">
                                                    {{ ucfirst($reservation->state->value) }}
                                                </span>
                                            </td>
                                            <td>
                                                @if ($reservation->state->value !== 'canceled')
                                                    <form action="{{ route('reservations.cancel', $reservation->id) }}"
                                                        method="POST" onsubmit="return confirm('Cancel this reservation?')"
                                                        class="d-inline">
                                                        @csrf
                                                        <button type="submit"
                                                            class="btn btn-sm btn-outline-danger">Cancel</button>
                                                    </form>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center">No reservations.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <nav class="pagination is-centered" role="navigation" aria-label="pagination">

                        {{-- <div class="card-footer"> --}}
                        {{-- {{ $reservations->links() }} --}}
                        {{-- </div> --}}
                    </nav>
                </div>
            </div>

            <!-- Section 2: Reservations Received -->
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0">Reservations Received</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover table-sm align-middle mb-0">
                                <thead class="table-light">
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
                                                <a href="{{ route('cars.show', $reservation->car->id) }}">
                                                    {{ $reservation->car->name }}
                                                </a>
                                            </td>
                                            <td>{{ $reservation->user->name }}</td>
                                            <td>{{ \Carbon\Carbon::parse($reservation->reservation_date)->format('Y-m-d H:i') }}
                                            </td>
                                            <td>
                                                <span
                                                    class="badge bg-{{ $reservation->state->value === 'canceled' ? 'danger' : ($reservation->state->value === 'completed' ? 'success' : 'info') }}">
                                                    {{ ucfirst($reservation->state->value) }}
                                                </span>
                                            </td>

                                            <td>
                                                @if ($reservation->state->value !== 'canceled' && $reservation->state->value !== 'completed')
                                                    <form action="{{ route('reservations.complete', $reservation->id) }}"
                                                        method="POST"
                                                        onsubmit="return confirm('Complete this reservation?')"
                                                        class="d-inline">
                                                        @csrf
                                                        <button type="submit"
                                                            class="btn btn-sm btn-outline-success">Complete</button>
                                                    </form>
                                                    <a  class="btn btn-sm btn-outline-success" href="{{route('reservations.view',$reservation->id)}}">View</a>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center">No reservations received.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    {{-- <div class="card-footer">
                    {{ $reservations_received->links() }}
                </div> --}}
                </div>
            </div>
        </div>
    </div>
@endsection
