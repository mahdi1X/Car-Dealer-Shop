@extends('layouts.app')

@section('content')
    {{-- <nav class="navbar navbar-expand-md navbar-light custom-navbar"> --}}
    <a href="{{ route('cars.create') }}">
        <i class="fa fa-plus fa-3x flex-shrink-0 fixed-bottom-button"
            style="border: 5px solid #4b4b4b; border-radius: 50%; padding: 10px; color: #4b4b4b; background-color: white;"></i>
    </a>
    <div class="container-fluid">
        <div class="brand-scroll-container">

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="row">


                @foreach ($cars as $car)
                    <div class="col-sm-4 mb-4">

                        <div class="card h-100" style="height: 400px; display: flex; flex-direction: column;">
                            <img
                                src="{{ asset('storage/' . $car->image) }}" alt="Car Image"
                                style="height: 50%; object-fit: cover;">
                            <div class="p-3 d-flex flex-column justify-content-between" style="height: 50%;">
                                <div>
                                    <h5 class="card-title">{{ $car->name }}</h5>
                                    <p class="brand">Brand: {{ $car->brand->name }}</p>
                                    <p class="price">$ {{ number_format($car->price, 2) }}</p>
                                </div>
                                <div class="mt-auto d-flex justify-content-between">
                                    <a href="{{ route('cars.edit', $car->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                    <a href="{{ route('cars.show', ['car' => $car->id]) }}" class="btn btn-sm btn-primary">View</a>
                                    {{-- <a href="" class="btn btn-sm btn-primary">Edit</a> --}}
                                    {{-- <form action="{{ route('cars.destroy', $car->id) }}" method="POST" --}}
                                    <form action="{{ route('cars.destroy', $car->id) }}" method="POST"
                                        onsubmit="return confirm('Are you sure?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    {{-- </nav> --}}
@endsection
