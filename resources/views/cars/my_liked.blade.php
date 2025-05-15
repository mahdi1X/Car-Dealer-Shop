@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">My Liked Cars</h1>

    @if ($likedCars->isEmpty())
        <p>You haven't liked any cars yet.</p>
    @else
        <div class="row">
            @foreach ($likedCars as $car)
            <div class="col-md-4 mb-4">
                <div class="card h-100" style="height: 450px; display: flex; flex-direction: column;">
                    <div class="card-header">
                        <h5 class="card-title mb-0">{{ $car->name }}</h5>
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
