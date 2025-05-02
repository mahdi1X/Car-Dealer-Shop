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
                <div class="col-sm-4 mb-4">
                    <div class="card h-100" style="height: 400px; display: flex; flex-direction: column;">
                        <img src="{{ asset('storage/' . $car->image) }}" alt="Car Image"
                            style="height: 50%; object-fit: cover;">
                        <div class="p-3" style="height: 50%; overflow: hidden;">
                            <h5 class="card-title">{{ $car->name }}</h5>
                            <p class="brand">Brand: {{ $car->brand->name }}</p>
                            <p class="price">$ {{ number_format($car->price, 2) }}</p>
                        </div>
                        <a href="{{route('cars.show', ['car' => $car->id]) }}" class="btn btn-primary">
                            More Details
                        </a>
                     
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
