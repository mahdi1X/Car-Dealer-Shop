@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Reservation Details</h1>

    <div class="card">
        <div class="card-header">
            <h2>Reservation ID: {{ $reservation->id }}</h2>
        </div>
        <div class="card-body">
            <p><strong>Reservation Date:</strong> {{ $reservation->reservation_date }}</p>

            <h4>Car Details:</h4>
            <p><strong>Name:</strong> {{ $reservation->car->name }}</p>
            <p><strong>Color:</strong> {{ $reservation->car->color }}</p>
            <p><strong>Year:</strong> {{ $reservation->car->year }}</p>

            <h4>User Details:</h4>
            <p><strong>Name:</strong> {{ $reservation->user->name }}</p>
            <p><strong>Email:</strong> {{ $reservation->user->email }}</p>

            <h4>State:</h4>
            <p><strong>Status:</strong> {{ $reservation->state->label() }}</p>
        </div>
    </div>

    <a href="{{ route('reservations.index') }}" class="btn btn-primary mt-3">Back to Reservations List</a>
</div>
@endsection
