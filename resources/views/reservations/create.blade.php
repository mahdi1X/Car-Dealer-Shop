@extends('layouts.app')

        @section('content')
            <div class="container mt-5">
                @if (session('msg'))
                    <div class="alert alert-info">
                        {{session('msg')}}
                    </div>
                @endif

                <h1 class="mb-4">Create Reservation</h1>

                <div class="card shadow-lg border-0 modern-form-card" style="border-radius: 18px; max-width: 520px; margin: 0 auto;">
                    <div class="card-header bg-primary text-white" style="border-radius: 18px 18px 0 0;">
                        <h3 class="mb-0">Reserving {{ $car->name }}</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('reservations.store') }}" method="POST">
                            @csrf

                            <input type="hidden" name="car_id" value="{{ $car->id }}" />

                            <!-- Reservation Date Input -->
                            <div class="form-group mb-3">
                                <label for="reservation_date" class="form-label">Reservation Date</label>
                                <input type="datetime-local" name="reservation_date" id="reservation_date" class="form-control"
                                    required>
                            </div>

                            <!-- Submit Button -->
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">Submit Reservation</button>
                            </div>
                        </form>
                    </div>
                </div>
                <style>
                    .modern-form-card {
                        background: linear-gradient(120deg, #f8fafc 80%, #e0f7fa 100%);
                        border-radius: 18px;
                        box-shadow: 0 8px 32px rgba(75,139,145,0.10), 0 2px 8px rgba(0,0,0,0.04);
                        margin-bottom: 32px;
                        max-width: 520px;
                        width: 100%;
                        /* Remove hover animation */
                        transition: none;
                    }
                    .modern-form-card:hover {
                        box-shadow: 0 8px 32px rgba(75,139,145,0.10), 0 2px 8px rgba(0,0,0,0.04);
                        transform: none;
                    }
                    .modern-form-card .card-header {
                        font-weight: 600;
                        font-size: 1.1rem;
                        background: linear-gradient(90deg, #4b8b91 60%, #2196F3 100%) !important;
                        color: #fff !important;
                        border: none;
                    }
                </style>
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
