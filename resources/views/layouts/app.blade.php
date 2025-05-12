<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ 'CartMart' }}</title>
    
    <!-- Fonts & Icons -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Barlow:wght@600;700&family=Ubuntu:wght@400;500&display=swap"
        rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Styles & Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <link href="{{ asset('lib/animate/animate.min.css') }}" rel="stylesheet">
    <link href="{{ asset('lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">
    <link href="{{ asset('lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md custom-navbar fixed-top">
            <div class="container">
                <!-- Logo -->
                <a class="navbar-brand d-flex align-items-center animated-border" href="{{ url('/') }}">
                    <img src="{{ asset('storage/common-images/WhatsApp Image 2025-05-01 at 20.15.24_0501f586.jpg') }}"
                        alt="CarMart Logo">
                </a>

                <!-- Toggler -->
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent">
                    <span class="navbar-toggler-icon"></span>
                </button>

                @if (Auth::check() && Auth::user()->role == 'customer')
                    <!-- Search bar (centered) -->
                    <form class="d-flex mx-auto" action="{{ route('cars.index') }}" method="GET"
                        style="max-width: 400px; width: 100%;">
                        <input class="form-control me-2" type="search" name="q" placeholder="Search brands..."
                            aria-label="Search">
                        <button class="btn btn-outline-light" type="submit"
                            style="background-color: #4b4b4b">Search</button>
                    </form>
                    <li class="nav-item">
                        <a class="navbar-brand animated-border"
                            href="{{ route('recommended.cars') }}">Recommended</a>
                    </li>
                @endauth

                <!-- Navigation links -->
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto align-items-center">

               
                        <li class="nav-item">
                            <a class="navbar-brand animated-border" href="{{ route('policy') }}">Policies</a>
                        </li>

                        @guest
                            {{-- Non Logged In User Routes --}}
                        @else
                            {{-- Logged In User --}}
                            @if (Auth::user()->role == 'admin')
                                <li class="nav-item">
                                    <a class="navbar-brand animated-border" href="{{ url('admin_users') }}">Admins</a>
                                </li>
                                <li class="nav-item">
                                    <a class="navbar-brand animated-border"
                                        href="{{ route('brands.index') }}">Brands</a>
                                </li>
                                <li class="nav-item">
                                    <a class="navbar-brand animated-border"
                                        href="{{ route('analytics.index') }}">Analytics</a>
                                </li>
                            @else
                           
                                <li class="nav-item">
                                    <a class="navbar-brand animated-border" href="{{ route('mypage') }}">My
                                        Listings</a>
                                </li>
                                <li class="nav-item">
                                    <a class="navbar-brand animated-border" href="{{ route('reservations.index') }}">My
                                        Reserved Cars</a>
                                </li>
                            @endif
                        @endguest





                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="navbar-brand animated-border"
                                        href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="navbar-brand animated-border"
                                        href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle text-white" href="#"
                                    data-bs-toggle="dropdown">
                                    {{ Auth::user()->name }}
                                </a>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                        class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
        </div>
    </nav>

    <!-- Main content -->
    <main class="py-0" style="margin-top: 80px;">
        @yield('content')
    </main>
</div>

<!-- Custom Styles -->
<style>
    .custom-navbar {
        background: linear-gradient(135deg, #4b4b4b, #777777);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
        border-bottom: 1px solid #ddd;
        height: 80px;
        z-index: 1000;
    }

    .navbar-brand {
        color: #f5f5f5;
        transition: all 0.3s ease;
    }

    .navbar-brand:hover {
        color: #ffffff;
    }

    .navbar-brand img {
        height: 60px;
        vertical-align: middle;
    }

    .animated-border {
        position: relative;
        display: inline-block;
        color: #f5f5f5;
        text-decoration: none;
        font-size: 1.1rem;
        padding: 4px 8px;
    }

    .animated-border::before,
    .animated-border::after {
        content: '';
        position: absolute;
        width: 0;
        height: 2px;
        background-color: #00bcd4;
        transition: 0.4s ease;
    }

    .animated-border::before {
        bottom: 0;
        left: 0;
    }

    .animated-border::after {
        top: 0;
        right: 0;
    }

    .animated-border:hover::before,
    .animated-border:hover::after {
        width: 100%;
    }

    form.d-flex input {
        border-radius: 5px;
    }
</style>
</body>

</html>
