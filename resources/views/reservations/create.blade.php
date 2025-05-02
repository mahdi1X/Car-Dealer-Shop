        @extends('layouts.app')

        @section('content')
            <div class="container">

                @if (session('msg'))
                    <div class="alert alert-info">
                        {{session('msg')}}
                    </div>
                @endif

                <h1>Create Reservation</h1>

                <div class="card">
                    <div class="card-header">
                        <h3>Reserving {{ $car->name }}</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('reservations.store') }}" method="POST">
                            @csrf

                            <input type="hidden" name="car_id" value="{{ $car->id }}" />

                            <!-- Reservation Date Input -->
                            <div class="form-group">
                                <label for="reservation_date">Reservation Date</label>
                                <input type="datetime-local" name="reservation_date" id="reservation_date" class="form-control"
                                    required>
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" class="btn btn-primary">Submit Reservation</button>
                        </form>
                    </div>
                </div>
            </div>
            <script>
                document.addEventListener("DOMContentLoaded", function () {
                    let reservationInput = document.getElementById("reservation_date");
            
                    function setMinDateTime() {
                        let now = new Date();
                        now.setHours(now.getHours() + 24);
                        let minDateTime = now.toISOString().slice(0, 16);
                        reservationInput.min = minDateTime;
                    }
            
                    setMinDateTime();
                });
            </script>
            
        @endsection
