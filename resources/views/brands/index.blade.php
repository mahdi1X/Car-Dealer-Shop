@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-md-9"><h1 class="mb-4">Car Brands</h1></div>
        <div class="col-md-3">

            <a href="{{route('brands.create')}}" class="btn btn-primary">Add Brand</a>
        </div>
    </div>
    

    <div class="row row-cols-1 row-cols-md-3 g-4">
        @forelse($brands as $brand)
            <div class="col">
                <div class="card h-100 shadow-sm border-0">
                    @if($brand->icon)
                        <img src="{{ asset('storage/' . $brand->icon) }}" class="card-img-top p-3" alt="{{ $brand->name }}" style="max-height: 150px; object-fit: contain;">
                    @endif
                    <div class="card-body">
                        <h5 class="card-title">{{ $brand->name }}</h5>
                        <a href="{{ route('brands.show', $brand->id) }}" class="btn btn-outline-primary">View Details</a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col">
                <div class="alert alert-info">No brands found.</div>
            </div>
        @endforelse
    </div>
</div>
@endsection
