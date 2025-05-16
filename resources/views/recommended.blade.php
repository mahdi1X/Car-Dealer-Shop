@extends('layouts.app')

@section('content')
<div class="container">
    <br>
    <h1 class="mb-4 text-center">Recommended Cars:</h1>
    <br><br>

   <div class="row d-flex flex-wrap">
    @foreach ($cars as $car)
    <div class="car-card col-md-4 mb-4 d-flex align-items-stretch" >
        <div class="card w-100 d-flex flex-column">
            <br>
            <div class="card-header">
                <h2 class="mb-4 fancy-title text-center">{{ $car->name }}</h2>
            </div>
            <div class="card-body d-flex flex-column">
                <p><strong>Brand:</strong> {{ $car->brand->name }}</p>
                <p><strong>Year:</strong> {{ $car->year }}</p>
                <p><strong>Price:</strong> ${{ number_format($car->price, 2) }}</p>
                <p><strong>Length:</strong> {{ $car->length }} meters</p>
                <p class="mb-4 fancy-title text-center">
                    👍 Likes: {{ $car->likes_count }}   
                </p>

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
    border: 2px solid transparent;
    border-radius: 12px;
    transition: all 0.4s ease;
    background-color: #fff;
    box-shadow: 0 0 0 rgba(0, 255, 255, 0);
    will-change: transform, box-shadow;
}

.car-card:hover {
    box-shadow: 0 0 18px rgba(0, 0, 0, 0.7);
    border-color: rgb(0, 0, 0);
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
