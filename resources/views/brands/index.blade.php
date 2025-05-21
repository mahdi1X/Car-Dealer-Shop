@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <br>
    <div class="row">
        <div class="col-md-9"><h1 class="mb-4">Car Brands:</h1></div>
        <br>
        <div class="col-md-3">
            <a href="{{route('brands.create')}}" class="btn btn-primary">Add Brand</a>
        </div>
    </div>
    

    <div class="row row-cols-1 row-cols-md-3 g-4">
        @forelse($brands as $brand)
            <div  class="car-card col">
                <a href="{{ route('brands.show', $brand->id) }}">
                <div class="card h-100 shadow-sm border-0">
                    @if($brand->icon)
                        <img  src="{{ asset('storage/' . $brand->icon) }}" class="card-img-top p-3" alt="{{ $brand->name }}" style="max-height: 150px; object-fit: contain;">
                    @endif
                    <div  class="card-body">
                        <h5 class="card-title">{{ $brand->name }}</h5>
                        {{--<a href="{{ route('brands.show', $brand->id) }}" class="btn btn-outline-primary">View Details</a>--}}
                        <a href="{{ route('brands.edit', $brand->id) }}" class="btn btn-outline-primary">Update Brand</a>
                    </div>
                </div>
                </a>
            </div>
        @empty
            <div class="col">
                <div class="alert alert-info">No brands found.</div>
            </div>
        @endforelse
    </div>
</div>
@endsection
<style>.car-card {
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
}</style>
