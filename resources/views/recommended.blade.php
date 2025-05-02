@extends('layouts.app')

@section('content')
<div class="container">
    <br>
    <h1>Recommended Cars</h1>
    <br>
    <br>
    <br>

    <div class="row">
        @foreach ($cars as $car)
        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-header">
                    <h2>{{ $car->name }}</h2>
                </div>
                <div class="card-body">
                    <p><strong>Brand:</strong> {{ $car->brand->name }}</p>
                    <p><strong>Year:</strong> {{ $car->year }}</p>
                    <p><strong>Price:</strong> ${{ number_format($car->price, 2) }}</p>
                    <p><strong>Length:</strong> {{ $car->length }} meters</p>

                    @if ($car->image)
                    <div>
                        <img src="{{ asset('storage/' . $car->image) }}" alt="{{ $car->name }}" style="max-width: 100%; height: auto;">
                    </div>
                    @else
                    <p><strong>Image:</strong> No image available</p>
                    @endif

                    <a href="{{route('cars.show', ['car' => $car->id]) }}" class="btn btn-primary">
                        More Details
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>


@endsection

<!-- Add inline or separate CSS -->
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
</style>
