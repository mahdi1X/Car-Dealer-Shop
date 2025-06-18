@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <div class="card shadow-sm border-0 mb-4">
            <div class="row g-0 align-items-center">
                @if ($brand->icon)
                    <div class="col-md-3 text-center p-3">
                        <img src="{{ asset('storage/' . $brand->icon) }}" alt="{{ $brand->name }}" class="img-fluid"
                            style="max-height: 150px; object-fit: contain;">
                    </div>
                @endif
                <div class="col-md-9">
                    <div class="card-body">
                        <h2 class="card-title">{{ $brand->name }}</h2>
                        <p class="card-text"><strong>Total Cars:</strong> {{ $brand->cars->count() }}</p>
                    </div>
                </div>
            </div>
        </div>

        <h4 class="mb-3">Cars by {{ $brand->name }}</h4>
        <div class="row row-cols-1 row-cols-md-2 g-3">
            @forelse($brand->cars as $car)
                <div class="col">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="row g-0">
                            <div class="col-md-4">
                                @if ($car->image)
                                    <img src="{{ asset('storage/' . $car->image) }}" alt="{{ $car->model }}"
                                        class="img-fluid rounded-start" style="height: 100%; object-fit: cover;">
                                @else
                                    <div class="d-flex align-items-center justify-content-center bg-secondary text-white h-100"
                                        style="min-height: 150px;">
                                        <span>No Image</span>
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $car->name ?? 'Unnamed Car' }}</h5>
                                    <p class="card-text">$ {{ number_format($car->price, 2) }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col">
                    <div class="alert alert-warning">No cars available for this brand.</div>
                </div>
            @endforelse
        </div>

        <div class="mt-4">
            <a href="{{ route('brands.index') }}" class="btn btn-secondary">Back to Brands</a>
            @if($brand->cars->count() == 0)
                <form action="{{ route('brands.destroy', $brand->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this brand?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger ms-2">Delete Brand</button>
                </form>
            @endif
        </div>
    </div>
@endsection
