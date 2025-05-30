@extends('layouts.app')

@section('content')
    @push('styles')
        <style>
            .background-wrapper {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                z-index: -1;
                overflow: hidden;
                pointer-events: none;
            }

            .bg-image {
                width: 100%;
                height: 100%;
                object-fit: cover;
                margin-top: 0;
            }

            .overlay {
                position: fixed;
                top: 0;
                left: 0;
                height: 100%;
                width: 100%;
                background: rgba(0, 0, 0, 0.4);
                z-index: 0;
                pointer-events: none;
            }

            .container {
                position: relative;
                z-index: 1;
            }

            .card {
                background: rgba(255, 255, 255, 0.1);
                backdrop-filter: blur(10px);
                border: none;
                border-radius: 0rem;
                box-shadow: 0 20px 35px rgba(0, 0, 0, 0.3);
                margin-top: 60px;
                color: white;
                animation: fadeIn 2.5s ease;
            }

            .card-header {
                background: linear-gradient(135deg, #c97272, #66c0c8, #4b4b4b);
                border-top-left-radius: 1rem;
                border-top-right-radius: 1rem;
                font-size: 1.5rem;
                font-weight: bold;
                text-align: center;
                color: white;
            }

            .form-control {
                background-color: rgba(255, 255, 255, 0.2);
                color: white;
                border: 1px solid rgba(255, 255, 255, 0.3);
                border-radius: 0.5rem;
                transition: all 0.3s ease-in-out;
            }

            .form-control::placeholder {
                color: rgba(255, 255, 255, 0.7);
            }

            .form-control:focus {
                background-color: rgba(255, 255, 255, 0.3);
                color: #fff;
                box-shadow: 0 0 10px rgba(0, 123, 255, 0.6);
            }

            .form-select {
                background-color: rgba(255, 255, 255, 0.2);
                color: white;
                border: 1px solid rgba(255, 255, 255, 0.3);
                border-radius: 0.5rem;
            }

            .btn-primary {
                background-color: #007bff;
                border: none;
                padding: 0.6rem 1.5rem;
                border-radius: 0.5rem;
                transition: 0.3s ease;
            }

            .btn-primary:hover {
                background-color: #0056b3;
                box-shadow: 0 0 10px rgba(0, 123, 255, 0.6);
            }

            select.form-select,
            select.form-control {
                background-color: rgba(255, 255, 255, 0.2);
                color: white;
                border: 1px solid rgba(255, 255, 255, 0.3);
                border-radius: 0.5rem;
            }

            select option {
                background-color: #222;
                color: #fff;
            }


            label {
                font-weight: 500;
                color: white;
            }

            .invalid-feedback {
                color: #ffc4c4;
            }

            @keyframes fadeIn {
                from {
                    opacity: 0;
                    transform: translateY(30px);
                }

                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }
        </style>
    @endpush

    <!-- Background Image -->
    <div class="background-wrapper">
        <img src="{{ asset('img/photo-1495506539593-87a23e41b6fe.jpeg') }}" class="bg-image" alt="Background">
    </div>

    <!-- Overlay -->
    <div class="overlay"></div>

    <!-- Register Form -->
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        {{ __('Register') }}
                    </div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
                            @csrf

                            {{-- Name --}}
                            <div class="mb-3">
                                <label for="name">{{ __('Name') }}</label>
                                <input id="name" type="text"
                                    class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" name="name"
                                    value="{{ old('name') }}" required autofocus>
                                @if ($errors->has('name'))
                                    <div class="invalid-feedback">{{ $errors->first('name') }}</div>
                                @endif
                            </div>

                            {{-- Email --}}
                            <div class="mb-3">
                                <label for="email">{{ __('Email Address') }}</label>
                                <input id="email" type="email"
                                    class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" name="email"
                                    value="{{ old('email') }}" required>
                                @if ($errors->has('email'))
                                    <div class="invalid-feedback">{{ $errors->first('email') }}</div>
                                @endif
                            </div>

                            {{-- Password --}}
                            <div class="mb-3">
                                <label for="password">{{ __('Password') }}</label>
                                <input id="password" type="password"
                                    class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}" name="password"
                                    required>
                                @if ($errors->has('password'))
                                    <div class="invalid-feedback">{{ $errors->first('password') }}</div>
                                @endif
                            </div>

                            {{-- Confirm Password --}}
                            <div class="mb-3">
                                <label for="password-confirm">{{ __('Confirm Password') }}</label>
                                <input id="password-confirm" type="password" class="form-control"
                                    name="password_confirmation" required>
                            </div>

                            {{-- Region --}}
                            <div class="mb-3">
                                <label for="region">{{ __('Region') }}</label>
                                <select id="region" name="region"
                                    class="form-select {{ $errors->has('region') ? 'is-invalid' : '' }}" required>
                                    <option value="">{{ __('Select Region') }}</option>
                                    @foreach (['Beirut', 'Mount Lebanon', 'North Lebanon', 'South Lebanon', 'Nabatieh', 'Bekaa', 'Baalbek-Hermel', 'Akkar'] as $region)
                                        <option value="{{ $region }}"
                                            {{ old('region') == $region ? 'selected' : '' }}>
                                            {{ $region }}
                                        </option>
                                    @endforeach
                                </select>
                                @if ($errors->has('region'))
                                    <div class="invalid-feedback">{{ $errors->first('region') }}</div>
                                @endif
                            </div>

                            {{-- Address --}}
                            <div class="mb-3">
                                <label for="address">{{ __('Address') }}</label>
                                <input id="address" type="text"
                                    class="form-control {{ $errors->has('address') ? 'is-invalid' : '' }}" name="address"
                                    value="{{ old('address') }}" required>
                                @if ($errors->has('address'))
                                    <div class="invalid-feedback">{{ $errors->first('address') }}</div>
                                @endif
                            </div>

                            {{-- Payment Method --}}
                            <div class="mb-3">
                                <label for="payment_method">{{ __('Payment Method') }}</label>
                                <select id="payment_method" name="payment_method" class="form-select">
                                    <option value="visa_card" {{ old('payment_method') == 'visa_card' ? 'selected' : '' }}>
                                        Visa Card</option>
                                    <option value="cash" {{ old('payment_method') == 'cash' ? 'selected' : '' }}>Cash
                                    </option>
                                    <option value="bnpl" {{ old('payment_method') == 'bnpl' ? 'selected' : '' }}>BNPL
                                    </option>
                                </select>
                            </div>

                            {{-- Profile Picture --}}
                            <div class="mb-3">
                                <label  for="profile_picture">{{ __('Profile Picture') }}</label>
                                <input style="background-color: transparent" id="profile_picture" type="file"
                                    class="form-control {{ $errors->has('profile_picture') ? 'is-invalid' : '' }}"
                                    name="profile_picture" accept="image/*">
                                @if ($errors->has('profile_picture'))
                                    <div class="invalid-feedback">{{ $errors->first('profile_picture') }}</div>
                                @endif
                            </div>

                            {{-- Submit --}}
                            <div class="mb-0 text-end">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

