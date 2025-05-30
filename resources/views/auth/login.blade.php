@extends('layouts.app')

@section('content')
    @push('styles')
        <style>
            /* Fullscreen background wrapper */
            .background-wrapper {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                z-index: -1;
                /* Keeps it behind all other elements */
                overflow: hidden;
                pointer-events: none;

            }

            .bg-image {
                width: 100%;
                height: 100%;
                object-fit: cover;
                /* Ensures full coverage without distortion */
                margin-top: 0;
                /* You can adjust this */
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

            .btn-link {
                color: #aad8ff;
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
        <img src="{{ asset('img\photo-1495506539593-87a23e41b6fe.jpeg') }}" class="bg-image" alt="Background">
    </div>

    <!-- Overlay -->
    <div class="overlay"></div>

    <!-- Main Content -->
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Login') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            {{-- EMAIL --}}
                            <div class="mb-3">
                                <label for="email">{{ __('Email Address') }}</label>
                                <input id="email" type="email"
                                    class="form-control @error('email') is-invalid @enderror" name="email"
                                    value="{{ old('email') }}" required autocomplete="email" autofocus>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            {{-- PASSWORD --}}
                            <div class="mb-3">
                                <label for="password">{{ __('Password') }}</label>
                                <input id="password" type="password"
                                    class="form-control @error('password') is-invalid @enderror" name="password" required
                                    autocomplete="current-password">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            {{-- REMEMBER ME --}}
                            <div class="mb-3 form-check text-start">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                    {{ old('remember') ? 'checked' : '' }}>
                                <label class="form-check-label" for="remember">
                                    {{ __('Remember Me') }}
                                </label>
                            </div>

                            {{-- BUTTONS --}}
                            <div class="mb-0 text-end">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
