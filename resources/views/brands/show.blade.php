@extends('layouts.app')
@section('content')
<div class="container bg-white m-5 rounded">
    <H1>Cars</H1>
    <!-- Card grid for displaying cars -->
    <div class="row p-1">

        @foreach ($cars as $car)
            <div class="col-sm-3 rounded">
                <div class="card rounded">
                    <img src="{{ asset('storage/' . $car->image) }}" style="width: 100%; height: 150px; object-fit: contain" alt="Car Image">
                    <div class="p-3">
                        <h5 class="card-title">{{ $car->name }}</h5>
                        <p class="brand">Brand: {{ $car->brand->name }}</p>
                        {{-- <p class="year">Year: {{ $car->year }}</p> --}}
                        {{-- <p class="color">Color: {{ $car->color }}</p> --}}
                        <p class="price">$ {{ number_format($car->price, 2) }}</p>
                        {{-- <button > --}}
                            <a href="{{route('cars.show', ['car' => $car->id]) }}" class="btn btn-primary">
                                More Details
                            </a>
                            
                        {{-- </button> --}}
                        {{-- <p class="length">Length: {{ $car->length }} meters</p> --}}
                        {{-- <a href="{{ route('cars.show', $car->id) }}" class="btn btn-custom">View Details</a> --}}
                    </div>
                </div>
            </div>
        @endforeach
    </div></div>
@endsection