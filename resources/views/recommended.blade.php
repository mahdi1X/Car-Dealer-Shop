@extends('layouts.app')

@section('content')
<div class="container">
    <br>
    <h1>Recommended Cars</h1>
    <br><br><br>

    <div class="row d-flex flex-wrap">
        @foreach ($cars as $car)
        <div class="col-md-4 mb-4 d-flex align-items-stretch">
            <div class="card w-100 d-flex flex-column">
                <div class="card-header">
                    <h2 class="h5">{{ $car->name }}</h2>
                </div>
                <div class="card-body d-flex flex-column">
                    <p><strong>Brand:</strong> {{ $car->brand->name }}</p>
                    <p><strong>Year:</strong> {{ $car->year }}</p>
                    <p><strong>Price:</strong> ${{ number_format($car->price, 2) }}</p>
                    <p><strong>Length:</strong> {{ $car->length }} meters</p>

                    @if ($car->image)
                    <div class="mb-3 text-center">
                        <img src="{{ asset('storage/' . $car->image) }}" alt="{{ $car->name }}" style="max-height: 200px; width: auto;" class="img-fluid">
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
</style>
