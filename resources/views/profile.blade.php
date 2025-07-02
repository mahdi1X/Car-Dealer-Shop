@extends('layouts.app')

@section('content')
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    <div class="container py-5" style="background-color: #f8f9fa;">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <!-- Profile Picture -->
                <div class="text-center mb-4">
                    @if ($user->profile_picture)
                        <img src="{{ asset('storage/' . $user->profile_picture) }}" class="rounded-circle shadow-lg"
                            width="150" height="150" style="border: 5px solid #0d6efd; object-fit: cover;"
                            alt="Profile Picture">
                    @else
                        <i class="bi bi-person-circle" style="font-size: 150px; color: #adb5bd;"></i>
                    @endif
                </div>

                    @if (Auth::id() === $user->id && Auth::user()->role !== 'manager')
                    <!-- Editable Profile Form -->
                    <div class="card border-0 shadow mb-5 modern-form-card" style="border-radius: 18px; max-width: 650px; margin: 0 auto;">
                        <div class="card-header bg-primary text-white text-center" style="border-radius: 18px 18px 0 0;">
                            <h4>Edit Profile</h4>
                        </div>
                        <div class="card-body bg-white">
                            <form method="POST" action="{{ route('user.update', $user->id) }}"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <!-- Profile Picture Upload -->
                                <div class="mb-3">
                                    <label class="form-label text-primary">Change Profile Picture</label>
                                    <input type="file" name="profile_picture" class="form-control" accept="image/*">
                                </div>

                                <!-- Name -->
                                <div class="mb-3">
                                    <label class="form-label text-primary">Name</label>
                                    <input type="text" name="name" value="{{ old('name', $user->name) }}"
                                        class="form-control" required>
                                </div>

                                <!-- Email -->
                                <div class="mb-3">
                                    <label class="form-label text-primary">Email</label>
                                    <input type="email" value="{{ $user->email }}" class="form-control" disabled>
                                </div>

                                <!-- Address -->
                                <div class="mb-3">
                                    <label class="form-label text-primary">Address</label>
                                    <input type="text" name="address" value="{{ old('address', $user->address) }}"
                                        class="form-control">
                                </div>

                                <!-- Payment Method -->
                                <div class="mb-3">
                                    <label class="form-label text-primary">Payment Method</label>
                                    <select name="payment_method" class="form-select">
                                        <option value="visa_card"
                                            {{ old('payment_method', $user->payment_method) == 'visa_card' ? 'selected' : '' }}>
                                            Visa Card</option>
                                        <option value="cash"
                                            {{ old('payment_method', $user->payment_method) == 'cash' ? 'selected' : '' }}>
                                            Cash</option>
                                        <option value="bnpl"
                                            {{ old('payment_method', $user->payment_method) == 'bnpl' ? 'selected' : '' }}>
                                            BNPL</option>
                                    </select>
                                </div>

                                <!-- Region -->
                                <div class="mb-3">
                                    <label class="form-label text-primary">Region</label>
                                    <select name="region" class="form-select" required>
                                        @php
                                            $regions = [
                                                'Beirut',
                                                'Mount Lebanon',
                                                'North Lebanon',
                                                'South Lebanon',
                                                'Bekaa',
                                                'Nabatieh',
                                            ];
                                        @endphp
                                        <option value="">Select Region</option>
                                        @foreach ($regions as $region)
                                            <option value="{{ $region }}"
                                                {{ old('region', $user->region) == $region ? 'selected' : '' }}>
                                                {{ $region }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="text-center mt-4">
                                    <button type="submit" class="btn btn-primary px-4">Update Profile</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <style>
                        .modern-form-card {
                            background: linear-gradient(120deg, #f8fafc 80%, #e0f7fa 100%);
                            border-radius: 18px;
                            box-shadow: 0 8px 32px rgba(75,139,145,0.10), 0 2px 8px rgba(0,0,0,0.04);
                            margin-bottom: 32px;
                            max-width: 650px;
                            width: 100%;
                            /* Remove hover animation */
                            transition: none;
                        }
                        .modern-form-card:hover {
                            box-shadow: 0 8px 32px rgba(75,139,145,0.10), 0 2px 8px rgba(0,0,0,0.04);
                            transform: none;
                        }
                        .modern-form-card .card-header {
                            font-weight: 600;
                            font-size: 1.1rem;
                            background: linear-gradient(90deg, #4b8b91 60%, #2196F3 100%) !important;
                            color: #fff !important;
                            border: none;
                        }
                    </style>
                @else
                    <!-- View-Only Mode -->
                    <div class="card shadow mb-5 p-4 bg-white text-center">
                        <h3 class="text-primary">{{ $user->name }}</h3>
                        <hr>
                        <p><strong>Email:</strong> {{ $user->email }}</p>
                        <p><strong>Region:</strong> {{ $user->region }}</p>
                        <p><strong>Address:</strong> {{ $user->address }}</p>
                        <p><strong>Payment:</strong> {{ ucfirst($user->payment_method) }}</p>
                    </div>
                @endif

                <!-- Listed Cars -->
                <div class="mt-5">
                    <h4 class="text-primary mb-3">Listed Cars</h4>
                    @if ($cars->count())
                        <div class="row">
                            @foreach ($cars as $car)
                                <div class="col-md-4 mb-4">
                                    <a href="{{ route('cars.show', $car->id) }}" class="text-decoration-none">
                                        <div class="card border-0 shadow h-100 hover-shadow" style="transition: box-shadow 0.2s;">
                                            <img src="{{ asset('storage/' . $car->image) }}" class="card-img-top"
                                                style="object-fit: cover; height: 160px;" alt="{{ $car->name }}">
                                            <div class="card-body text-center">
                                                <h5 class="card-title text-primary">{{ $car->name }}</h5>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                        <style>
                            .hover-shadow:hover {
                                box-shadow: 0 8px 32px rgba(75,139,145,0.18), 0 4px 16px rgba(0,0,0,0.10) !important;
                                transform: scale(1.03);
                            }
                            .card-img-top {
                                transition: filter 0.2s;
                            }
                            a.text-decoration-none:hover .card-img-top {
                                filter: brightness(0.95) blur(0.5px);
                            }
                        </style>
                    @else
                        <p class="text-muted text-center">No cars listed yet.</p>
                    @endif
                    @if (Auth::id() !== $user->id && Auth::user()->role == 'customer')
                        <div class="text-center mb-4">
                            <a href="{{ route('user-reports.create', $user->id) }}" class="btn btn-outline-danger">
                                Report User
                            </a>
                        </div>
                        <!-- Report Modal -->
                    @endif
                </div>
                
            </div>
        </div>
    </div>
    </div>
@endsection
