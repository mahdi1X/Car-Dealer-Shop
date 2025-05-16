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
    <link href="https://fonts.googleapis.com/css2?family=Barlow:wght@600;700&family=Ubuntu:wght@400;500&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Styles & Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <link href="{{ asset('lib/animate/animate.min.css') }}" rel="stylesheet">
    <link href="{{ asset('lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">
    <link href="{{ asset('lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

    <!-- Lottie Loader -->
    <script src="https://unpkg.com/@dotlottie/player-component@2.7.12/dist/dotlottie-player.mjs" type="module"></script>
</head>

<body>
    <!-- Global Loading Spinner -->
    <div id="global-loader" style="
        position: fixed;
        top: 0;
        left: 0;
        z-index: 9999;
        width: 100vw;
        height: 100vh;
        background-color: white;
        display: flex;
        justify-content: center;
        align-items: center;
    ">
        <dotlottie-player 
            src="https://lottie.host/c45cc73a-acbd-49e2-8645-8f39ffc864f9/0FFT9LUnZF.lottie" 
            background="transparent" 
            speed="1" 
            style="width: 300px; height: 300px" 
            loop 
            autoplay>
        </dotlottie-player>
    </div>

    <div id="app">
        <!-- Navbar -->
       <nav class="navbar navbar-expand-md custom-navbar fixed-top">
    <div class="container">
        <!-- Logo -->
        <a class="navbar-brand d-flex align-items-center animated-border" href="{{ url('/') }}">
            <img src="{{ asset('storage/common-images/WhatsApp Image 2025-05-01 at 20.15.24_0501f586.jpg') }}" alt="CarMart Logo">
        </a>

        <!-- Toggler -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navbar content -->
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto align-items-center">
                @if (Auth::check() && Auth::user()->role == 'customer')
                    <li class="nav-item mx-3">
                        <form class="d-flex" action="{{ route('cars.index') }}" method="GET" style="max-width: 300px; width: 100%;">
                            <input class="form-control me-2" type="search" name="q" placeholder="Search brands..." aria-label="Search">
                            <button class="btn btn-outline-light" type="submit" style="background-color: #4b4b4b">
                                <i class="bi bi-search me-1"></i> Search
                            </button>
                        </form>
                    </li>
                    <li class="nav-item">
                        <a class="navbar-brand animated-border {{ request()->routeIs('recommended.cars') ? 'active-link' : '' }}" href="{{ route('recommended.cars') }}">
                            <i class="bi bi-star-fill me-1"></i> Recommended
                        </a>
                    </li>
                @endif

                @guest
                    {{-- Guest users --}}
                @else
                    @if (Auth::user()->role == 'admin')
                        <li class="nav-item">
                            <a class="navbar-brand animated-border {{ request()->is('admin_users*') ? 'active-link' : '' }}" href="{{ url('admin_users') }}">
                                <i class="bi bi-shield-lock-fill me-1"></i> Admins
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="navbar-brand animated-border {{ request()->routeIs('brands.index') ? 'active-link' : '' }}" href="{{ route('brands.index') }}">
                                <i class="bi bi-tags-fill me-1"></i> Brands
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="navbar-brand animated-border {{ request()->routeIs('analytics.index') ? 'active-link' : '' }}" href="{{ route('analytics.index') }}">
                                <i class="bi bi-graph-up me-1"></i> Analytics
                            </a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="navbar-brand animated-border {{ request()->routeIs('mypage') ? 'active-link' : '' }}" href="{{ route('mypage') }}">
                                <i class="bi bi-card-list me-1"></i> My Listings
                            </a>
                        </li>
                            <li class="nav-item">
                            <a class="navbar-brand animated-border {{ request()->routeIs('cars.liked') ? 'active-link' : '' }}" href="{{ route('cars.liked') }}">
                                <i class="bi bi-heart-fill me-1"></i> My Liked Cars
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="navbar-brand animated-border {{ request()->routeIs('reservations.index') ? 'active-link' : '' }}" href="{{ route('reservations.index') }}">
                                <i class="bi bi-calendar-check-fill me-1"></i> My Reserved Cars
                            </a>
                        </li>
                    
                    @endif
                @endguest

                <li class="nav-item">
                    <a class="navbar-brand animated-border {{ request()->routeIs('policy') ? 'active-link' : '' }}" href="{{ route('policy') }}">
                        <i class="bi bi-file-earmark-text-fill me-1"></i> Policies
                    </a>
                </li>

                @guest
                    @if (Route::has('login'))
                        <li class="nav-item">
                            <a class="navbar-brand animated-border {{ request()->routeIs('login') ? 'active-link' : '' }}" href="{{ route('login') }}">
                                <i class="bi bi-box-arrow-in-right me-1"></i> {{ __('Login') }}
                            </a>
                        </li>
                    @endif
                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="navbar-brand animated-border {{ request()->routeIs('register') ? 'active-link' : '' }}" href="{{ route('register') }}">
                                <i class="bi bi-person-plus-fill me-1"></i> {{ __('Register') }}
                            </a>
                        </li>
                    @endif
                @else
                    <li class="nav-item dropdown">
                        <a  id="navbarDropdown" class="nav-link dropdown-toggle text-white" href="#" data-bs-toggle="dropdown" style="color: #00bcd4;">
                            <i  style="color: #00bcd4"class="bi bi-person-circle me-1"></i> {{ Auth::user()->name }}
                        </a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                               {{ __('Logout') }}
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>

        <!-- Main Content -->
        <main class="py-0" style="margin-top: 80px;">
            @yield('content')
        </main>
    </div>

    <!-- Custom Styles -->
    <style>
        .custom-navbar {
            background: linear-gradient(135deg, #66c0c8, #4b4b4b);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
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
            background-color: #ffffff;
            transition: 0.6s ease;
        }
        .animated-border::before { bottom: 0; left: 0; }
        .animated-border::after { top: 0; right: 0; }
        .animated-border:hover::before,
        .animated-border:hover::after {
            width: 100%;
        }
        form.d-flex input { border-radius: 5px; }
        .active-link {
        color: cyan !important;
        cursor: default;
    }
    .active-link::before,
    .active-link::after {
        width: 100% !important;
        background-color: cyan !important;
        transition: none !important;
    }
    </style>

    <!-- Loader Hide Script -->
    <script>
        window.addEventListener('load', function () {
            const loader = document.getElementById('global-loader');
            if (loader) {
                loader.style.transition = 'opacity 2s ease';
                loader.style.opacity = '0';
                setTimeout(() => {
                    loader.style.display = 'none';
                }, 850);
            }
        });
    </script>
</body>

</html>
