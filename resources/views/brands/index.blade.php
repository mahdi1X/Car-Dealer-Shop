@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <br>
        <div class="row">
            <div class="col-md-9">
                <h1 class="mb-4">Car Brands:</h1>
            </div>
            <br>
            <div class="col-md-3">
                <a href="{{ route('brands.create') }}" class="btn btn-primary">Add Brand</a>
            </div>
        </div>

        @if (session('msg'))
            <div class="alert alert-success">
                {{ session('msg') }}
            </div>
        @endif

        <div class="row row-cols-1 row-cols-md-3 g-4">
            @forelse($brands as $brand)
                <div class="col d-flex">
                    <div class="car-card flex-fill w-100">
                        <a href="{{ route('brands.show', $brand->id) }}">
                            <div class="card h-100 shadow-sm border-0">
                                @if ($brand->icon)
                                    <img src="{{ asset('storage/' . $brand->icon) }}" class="card-img-top p-3"
                                        alt="{{ $brand->name }}" style="max-height: 150px; object-fit: contain;">
                                @endif
                                <div class="card-body">
                                    <h5 class="card-title">{{ $brand->name }}</h5>
                                    {{-- <a href="{{ route('brands.show', $brand->id) }}" class="btn btn-outline-primary">View Details</a> --}}
                                    <a href="{{ route('brands.edit', $brand->id) }}" class="btn btn-outline-primary">Update
                                        Brand</a>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            @empty
                <div class="col">
                    <div class="alert alert-info">No brands found.</div>
                </div>
            @endforelse
        </div>
        <style>
            .row.row-cols-md-3 {
                display: flex;
                flex-wrap: wrap;
            }

            .row.row-cols-md-3 > .col {
                display: flex;
                flex: 0 0 33.333333%;
                max-width: 33.333333%;
                padding-left: 12px;
                padding-right: 12px;
            }

            @media (max-width: 991.98px) {
                .row.row-cols-md-3 > .col {
                    flex: 0 0 50%;
                    max-width: 50%;
                }
            }

            @media (max-width: 767.98px) {
                .row.row-cols-md-3 > .col {
                    flex: 0 0 100%;
                    max-width: 100%;
                }
            }

            .car-card {
                position: relative;
                overflow: hidden;
                border: 2.5px solid #e0e7ef;
                border-radius: 18px;
                transition: box-shadow 0.3s, border-color 0.3s, transform 0.25s;
                background: linear-gradient(135deg, #f8fafc 70%, #e0f7fa 100%);
                box-shadow: 0 2px 16px rgba(75, 139, 145, 0.08), 0 1px 4px rgba(0, 0, 0, 0.03);
                margin-bottom: 32px !important;
                margin-top: 16px !important;
                margin-left: 8px !important;
                margin-right: 8px !important;
                padding: 0;
                will-change: transform, box-shadow;
                display: flex;
                flex-direction: column;
                height: 100%;
            }

            .car-card:hover {
                box-shadow: 0 8px 32px rgba(75, 139, 145, 0.18), 0 4px 16px rgba(0, 0, 0, 0.10);
                border-color: #4b8b91;
                background: linear-gradient(135deg, #e0f7fa 60%, #f8fafc 100%);
                transform: translateY(-7px) scale(1.03);
            }

            .car-card::before {
                content: '';
                position: absolute;
                top: -100%;
                left: -100%;
                width: 200%;
                height: 200%;
                background: radial-gradient(circle at center, rgba(75, 139, 145, 0.07), transparent 70%);
                transform: rotate(25deg);
                opacity: 0;
                transition: opacity 0.5s ease;
                pointer-events: none;
                z-index: 0;
            }

            .car-card:hover::before {
                opacity: 1;
            }

            .car-card .card-header,
            .car-card .card-body,
            .car-card .p-3 {
                position: relative;
                z-index: 1;
                background-color: transparent;
            }
        </style>
    </div>
@endsection
