@extends('layouts.app')
@section('content')
    <div class="container bg-white m-5 rounded">
        <H1>Cars</H1>
        @if (request('q'))
            <div class="alert alert-info">
                Showing results for: <strong>{{ request('q') }}</strong>
            </div>
        @endif
        <!-- Card grid for displaying cars -->
        <div class="row p-1">
            @foreach ($cars as $car)
                <div class="car-card col-sm-4 mb-4">
                    <div class="card h-100" style="height: 400px; display: flex; flex-direction: column;">
                        <img src="{{ asset('storage/' . $car->image) }}" alt="Car Image"
                            style="height: 50%; object-fit: cover;">
                        <div class="p-3" style="height: 50%; overflow: hidden;">
                            <h5 class="card-title">{{ $car->name }}</h5>
                            <p class="brand">Brand: {{ $car->brand->name }}</p>
                            <p class="price">$ {{ number_format($car->price, 2) }}</p>
                        </div>
                        <a href="{{ route('cars.show', ['car' => $car->id]) }}" class="btn btn-primary">
                            More Details
                        </a>
                        <br><br>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection

<style>
    .fixed-button {
        position: fixed;
        bottom: 20px;
        right: 20px;
        z-index: 1000;
        padding: 10px 20px;
        border-radius: 5px;
        text-decoration: none;
    }

    .car-card {
        position: relative;
        overflow: hidden;
        border: 2px solid rgba(255, 255, 255, 0.3);
        border-radius: 12px;
        transition: all 0.2s ease;
        background-color: rgba(255, 255, 255, 0.1);
        /* transparent white */
        backdrop-filter: blur(15px);
        /* applies the blur effect */
        -webkit-backdrop-filter: blur(10px);
        /* for Safari support */
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        display: flex;
        flex-direction: column;
        color: white;
    }


    /* Adjust hover background and border */
    .car-card:hover {
        box-shadow: 0 0 18px rgba(0, 0, 0, 0.7);
        border-color: rgba(255, 255, 255, 0.6);
        background-color: rgba(255, 255, 255, 0.25);
        transform: translateY(-9px);
    }


    /* Light sweep effect */
    .car-card::before {
        content: '';
        position: absolute;
        top: -100%;
        left: -100%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle at center, rgba(255, 255, 255, 0.15), transparent 70%);
        transform: rotate(25deg);
        opacity: 0;
        transition: opacity 0.5s ease;
        pointer-events: none;
        z-index: 0;
    }

    .car-card:hover::before {
        opacity: 1;
    }

    /* Keep card content visible above the light sweep */
    .car-card .card-header,
    .car-card .card-body {
        position: relative;
        z-index: 1;
        background-color: transparent;
    }
</style>
