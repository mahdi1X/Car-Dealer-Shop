@extends('layouts.app')


@section('content')
<div class="container">
    <br>
    <h1>Reservation Details:</h1>
    <br>
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
            <p><strong>Paying by:</strong> {{ $reservation->user->payment_method }}</p>

            <a href="mailto:{{ $reservation->user->email }}?subject=Regarding your car reservation&body=Hello {{ $reservation->user->name }},%0D%0A%0D%0AI am contacting you regarding your reservation for the car '{{ $reservation->car->name }}' (Reservation ID: {{ $reservation->id }}).My place is in: {{$reservation->user->address}} Please let me know if you have any questions.%0D%0A%0D%0AThank you."
                class="btn btn-success mt-3">
                 📧 Contact {{ $reservation->user->name }}
             </a>
             

        </div>
    </div>
    <br><br>
    <a href="{{ route('reservations.index') }}" class="btn btn-primary mt-3">Back to Reservations List</a>
    <br><br>
</div>
@endsection
