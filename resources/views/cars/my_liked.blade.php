@extends('layouts.app')

@section('content')
<br>
<div class="container"> 
    <h1 class="mb-4 text-center">My Liked Cars:</h1>

    @if ($likedCars->isEmpty())
        <p>You haven't liked any cars yet.</p>
    @else
        <div class="row">
            @foreach ($likedCars as $car)
            <div class="col-md-4 mb-4">
                <div class="car-card h-100 d-flex flex-column" style="height: 450px;">
                    <br>
                    <div class="card-header">
                        <h5 class="mb-4 text-center">{{ $car->name }}</h5>
                    </div>
                    @if ($car->image)
                        <img src="{{ asset('storage/' . $car->image) }}" alt="{{ $car->name }}" style="height: 50%; object-fit: cover;">
                    @else
                        <p><strong>Image:</strong> No image available</p>
                    @endif
                    <div class="p-3 d-flex flex-column justify-content-between" style="height: 50%;">
                        <div>
                            <p class="brand mb-1"><strong>Brand:</strong> {{ $car->brand->name }}</p>
                            <p class="year mb-1"><strong>Year:</strong> {{ $car->year }}</p>
                            <p class="price mb-1"><strong>Price:</strong> ${{ number_format($car->price, 2) }}</p>
                            <p class="length mb-1"><strong>Length:</strong> {{ $car->length }} meters</p>
                        </div>
                        <a href="{{ route('cars.show', $car->id) }}" class="btn btn-primary mt-2">More Details</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @endif
</div>
@endsection

<style>
.car-card {
    position: relative;
    overflow: hidden;
    border: 2px solid transparent;
    border-radius: 12px;
    transition: all 0.4s ease;
    background-color: #fff;
    box-shadow: 0 0 0 rgba(0, 255, 255, 0);
    will-change: transform, box-shadow;
}

.car-card:hover {
    box-shadow: 0 0 18px rgba(0, 255, 255, 0.7);
    border-color: rgb(81, 91, 91);
    transform: translateY(-4px);
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
.car-card .card-body,
.car-card .p-3 {
    position: relative;
    z-index: 1;
    background-color: transparent;
}

</style>


