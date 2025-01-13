@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>All Reservations</h1>

        <!-- Success Message -->
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <!-- Reservations Table -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Car</th>
                    <th>User</th>
                    <th>Reservation Date</th>
                    <th>State</th>
                    <th>Action</th> <!-- New column -->
                </tr>
            </thead>
            <tbody>
                @forelse ($reservations as $reservation)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td><a
                                href="{{ route('cars.show', ['car' => $reservation->car->id]) }}">{{ $reservation->car->name }}</a>
                        </td>
                        <td>{{ $reservation->user->name }}</td>
                        <td>{{ \Carbon\Carbon::parse($reservation->reservation_date)->format('Y-m-d H:i') }}</td>
                        <td>{{ ucfirst($reservation->state->value) }}</td>
                        <td>
                            <!-- Action Buttons -->
                            @if ($reservation->state->value !== 'canceled')
                                <form action="{{ route('reservations.cancel', ['reservation' => $reservation->id]) }}"
                                    method="POST" style="display:inline-block;">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-danger"
                                        onclick="return confirm('Are you sure you want to cancel this reservation?')">Cancel</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">No reservations found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Pagination -->
        {{ $reservations->links() }}
    </div>
@endsection
