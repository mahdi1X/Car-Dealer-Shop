@extends('layouts.app')

@section('content')
    <a href="{{ route('cars.create') }}" class="modern-add-car-btn" title="Add Car">
        <i class="fa fa-plus"></i>
    </a>
    <style>
        .modern-add-car-btn {
            position: fixed;
            bottom: 32px;
            right: 32px;
            z-index: 1200;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 64px;
            height: 64px;
            border-radius: 50%;
            background: linear-gradient(135deg, #4b8b91 60%, #2196F3 100%);
            color: #fff;
            font-size: 2.2rem;
            box-shadow: 0 8px 32px rgba(75,139,145,0.18), 0 4px 16px rgba(0,0,0,0.10);
            border: none;
            transition: background 0.2s, box-shadow 0.2s, transform 0.18s;
            cursor: pointer;
        }
        .modern-add-car-btn:hover, .modern-add-car-btn:focus {
            background: linear-gradient(135deg, #2196F3 60%, #4b8b91 100%);
            color: #fff;
            box-shadow: 0 12px 48px rgba(75,139,145,0.22), 0 6px 20px rgba(0,0,0,0.13);
            transform: scale(1.08) rotate(-8deg);
            text-decoration: none;
        }
        .modern-add-car-btn i {
            margin: 0;
            font-size: 2.2rem;
        }
        @media (max-width: 600px) {
            .modern-add-car-btn {
                width: 52px;
                height: 52px;
                font-size: 1.5rem;
                bottom: 16px;
                right: 16px;
            }
        }
    </style>

    <div class="container-fluid">
        <br>
        <h1 class="mb-4 text-center">My Cars:</h1>
        <br>
        <div class="brand-scroll-container">

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="row">
                @foreach ($cars as $car)
                    <div class="col-sm-4 mb-4">
                        <div class="car-card h-100 d-flex flex-column">
                            <br>
                            <!-- Card Header: Car Name -->
                            <div class="card-header">
                                <h5 class="mb-4 fancy-title text-center">{{ $car->name }}</h5>
                            </div>

                            <!-- Car Image -->
                            <img src="{{ asset('storage/' . $car->image) }}" alt="Car Image"
                                style="height: 50%; object-fit: cover;">

                            <!-- Card Body -->
                            <div class="p-3 d-flex flex-column justify-content-between" style="height: 50%;">
                                <div>
                                    <p class="brand mb-1"><strong>Brand:</strong> {{ $car->brand->name }}</p>
                                    <p class="price mb-1"><strong>Price:</strong> ${{ number_format($car->price, 2) }}</p>
                                </div>
                                <div class="mt-auto d-flex justify-content-between align-items-center" style="gap: 6px;">
                                    <a href="{{ route('cars.edit', $car->id) }}"
                                        class="btn btn-sm btn-primary btn-custom-sm">Edit</a>
                                    <a href="{{ route('cars.show', ['car' => $car->id]) }}"
                                        class="btn btn-sm btn-primary btn-custom-sm">View</a>
                                    <form action="{{ route('cars.destroy', $car->id) }}" method="POST"
                                        onsubmit="return confirm('Are you sure?');" style="margin: 0;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger btn-custom-sm">Delete</button>
                                    </form>
                                </div>

                            </div>
                        </div>
                    </div>
                @endforeach
            </div>


        </div>
    </div>
@endsection
<style>
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
        box-shadow: 0 0 18px rgba(32, 33, 33, 0.7);
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

    .btn-custom-sm {
        padding: 0.25rem 0.5rem;
        font-size: 0.8rem;
        line-height: 1;
        height: 30px;
        /* fixed height to control size */
        display: inline-flex;
        /* use inline-flex for better alignment */
        align-items: center;
        /* center text vertically */
        justify-content: center;
    }
</style>
