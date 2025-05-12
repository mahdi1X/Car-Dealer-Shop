@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Car Details</h1>

    <div class="card">
        <div class="card-header">
            <h2>{{ $car->name }}</h2>
        </div>
        <div class="card-body">
            <p><strong>Owner:</strong>{{$car->createdBy->name}}</p>
            <p><strong>Color:</strong> {{ $car->color }}</p>
            <p><strong>Brand:</strong> {{ $car->brand->name }}</p>
            <p><strong>Year:</strong> {{ $car->year }}</p>
            <p><strong>Price:</strong> ${{ number_format($car->price, 2) }}</p>
            <p><strong>KM Recorded:</strong> {{ $car->km_recorded }}</p>
            <p><strong>Length:</strong> {{ $car->length }} meters</p>
            
            @if ($car->image)
                <div>
                    <img src="{{ asset('storage/' . $car->image) }}" alt="{{ $car->name }}" style="max-width: 100%; height: auto;">
                </div>
            @else
                <p><strong>Image:</strong> No image available</p>
            @endif
        </div>
    </div>
</div>

<!-- Fixed Button -->
@if(Auth::check() && $car->created_by_id != Auth::id())
    <a href="{{ route('reservations.create', ['car' => $car->id]) }}" class="fixed-button btn btn-primary">
        Reserve Now
    </a>
@endif

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
