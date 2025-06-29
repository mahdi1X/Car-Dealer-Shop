@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <div class="card shadow-lg border-0 mb-5 brand-show-card" style="border-radius: 22px;">
            <div class="row g-0 align-items-center">
                @if ($brand->icon)
                    <div class="col-md-3 text-center p-4">
                        <img src="{{ asset('storage/' . $brand->icon) }}" alt="{{ $brand->name }}" class="img-fluid"
                            style="max-height: 140px; object-fit: contain; border-radius: 16px; box-shadow: 0 2px 12px rgba(75,139,145,0.10); background: #f8fafc;">
                    </div>
                @endif
                <div class="col-md-9">
                    <div class="card-body">
                        <h2 class="card-title mb-2" style="font-weight:700; color:#4b8b91;">{{ $brand->name }}</h2>
                        @if(Auth::check() && Auth::user()->role === 'admin')
                            <p class="card-text text-muted mb-2"><strong>Total Cars:</strong> {{ $brand->cars->count() }}</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <h4 class="mb-4" style="font-weight:600; color:#2b3a4a;">Cars by {{ $brand->name }}</h4>
        <div class="row row-cols-1 row-cols-md-2 g-4">
            @forelse($brand->cars as $car)
                <div class="col">
                    <div class="card h-100 border-0 shadow-sm car-list-card" style="border-radius: 18px;">
                        <div class="row g-0">
                            <div class="col-md-4">
                                @if ($car->image)
                                    <img src="{{ asset('storage/' . $car->image) }}" alt="{{ $car->model }}"
                                        class="img-fluid rounded-start"
                                        style="height: 100%; object-fit: cover; border-radius: 18px 0 0 18px;">
                                @else
                                    <div class="d-flex align-items-center justify-content-center bg-secondary text-white h-100"
                                        style="min-height: 150px; border-radius: 18px 0 0 18px;">
                                        <span>No Image</span>
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-8">
                                <div class="card-body d-flex flex-column justify-content-center h-100">
                                    <h5 class="card-title mb-2" style="font-weight:600;">{{ $car->name ?? 'Unnamed Car' }}</h5>
                                    <p class="card-text mb-1" style="color:#4b8b91;"><strong>Price:</strong> ${{ number_format($car->price, 2) }}</p>
                                    @if(Auth::check() && Auth::user()->role === 'customer')
                                        <a href="{{ route('cars.show', $car->id) }}" class="btn btn-outline-primary btn-sm mt-2" style="border-radius:8px;">View Details</a>
                                    @endif
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

        @if(Auth::check() && Auth::user()->role === 'admin')
            <div class="mt-4 d-flex align-items-center gap-2">
                <a href="{{ route('brands.index') }}" class="btn btn-secondary" style="border-radius:8px;">Back to Brands</a>
                @if($brand->cars->count() == 0)
                    <form action="{{ route('brands.destroy', $brand->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this brand?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger ms-2" style="border-radius:8px;">Delete Brand</button>
                    </form>
                @endif
            </div>
        @endif
    </div>
    <style>
        .brand-show-card {
            background: linear-gradient(120deg, #f8fafc 80%, #e0f7fa 100%);
            border-radius: 22px;
            box-shadow: 0 8px 32px rgba(75,139,145,0.10), 0 2px 8px rgba(0,0,0,0.04);
        }
        .car-list-card {
            background: #f8fafc;
            border-radius: 18px;
            box-shadow: 0 4px 24px rgba(75,139,145,0.08), 0 2px 8px rgba(0,0,0,0.04);
            transition: box-shadow 0.2s, transform 0.2s;
        }
        .car-list-card:hover {
            box-shadow: 0 8px 32px rgba(75,139,145,0.15), 0 4px 16px rgba(0,0,0,0.10);
            transform: translateY(-6px) scale(1.02);
        }
        .car-list-card .card-title {
            color: #2b3a4a;
        }
        .car-list-card .btn-outline-primary {
            border-width: 2px;
        }
    </style>
@endsection
