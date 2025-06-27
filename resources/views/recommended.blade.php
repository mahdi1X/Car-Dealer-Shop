@extends('layouts.app')

@section('content')
    <div class="container">
        <br>

        {{-- Toggle Buttons --}}
        <div class="d-flex justify-content-center mb-4">
            <a href="{{ route('cars.recommended') }}"
                class="btn {{ request()->routeIs('cars.recommended') ? 'btn-primary' : 'btn-outline-primary' }} me-2">
                AI Recommended
            </a>
            <a href="{{ route('recommended.cars') }}"
                class="btn {{ request()->routeIs('recommended.cars') ? 'btn-primary' : 'btn-outline-primary' }}">
                Most Liked
            </a>
        </div>

        {{-- Dynamic Header --}}
        <h1 style="color: black" class="mb-4 text-center">
            {{ request()->routeIs('cars.recommended') ? 'Recommended Cars By AI:' : 'Most Liked Cars:' }}
        </h1>
        <br><br>

        {{-- Car Cards --}}
        <div class="row gx-4 gy-4 d-flex flex-wrap">
            @forelse ($cars as $car)
                <div class="col-md-4 d-flex align-items-stretch">
                    <div class="car-card w-100">
                        <br>
                        <div class="card-header">
                            <h2 style="color: black" class="mb-4 fancy-title text-center">{{ $car->name }}</h2>
                        </div>
                        <div class="card-body d-flex flex-column">
                            <p style="color:rgb(0, 0, 0)"><strong>Brand:</strong> {{ $car->brand->name ?? 'N/A' }}</p>
                            <p style="color:black"><strong>Year:</strong> {{ $car->year }}</p>
                            <p style="color:black"><strong>Price:</strong> ${{ number_format($car->price, 2) }}</p>
                            <p style="color:black"><strong>Length:</strong> {{ $car->length }} meters</p>
                            <p style="color:black" class="mb-4 fancy-title text-center">
                                👍 Likes: {{ $car->likes_count ?? 0 }}
                            </p>

                            @if ($car->image)
                                <div class="mb-3 text-center">
                                    <img src="{{ asset('storage/' . $car->image) }}" alt="{{ $car->name }}"
                                        style="max-height: 200px; width: auto;" class="img-fluid">
                                </div>
                            @else
                                <p><strong>Image:</strong> No image available</p>
                            @endif

                            <div class="mt-auto text-center">
                                <a href="{{ route('cars.show', ['car' => $car->id]) }}" class="btn btn-primary">
                                    More Details
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-center">No cars to show.</p>
            @endforelse
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
        backdrop-filter: blur(15px);
        -webkit-backdrop-filter: blur(10px);
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        display: flex;
        flex-direction: column;
        color: white;
    }

    .car-card:hover {
        box-shadow: 0 0 18px rgba(0, 0, 0, 0.7);
        border-color: rgba(255, 255, 255, 0.6);
        background-color: rgba(255, 255, 255, 0.25);
        transform: translateY(-9px);
    }

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

    .car-card .card-header,
    .car-card .card-body {
        position: relative;
        z-index: 1;
        background-color: transparent;
    }
</style>
