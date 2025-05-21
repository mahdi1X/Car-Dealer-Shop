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
    @stack('styles')
    <!-- FullCalendar v6 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>




    <!-- Lottie Loader -->
    <script src="https://unpkg.com/@dotlottie/player-component@2.7.12/dist/dotlottie-player.mjs" type="module"></script>
</head>

<body>
    <!-- Global Loading Spinner -->
    <div id="global-loader"
        style="
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
        <dotlottie-player src="https://lottie.host/c45cc73a-acbd-49e2-8645-8f39ffc864f9/0FFT9LUnZF.lottie"
            background="transparent" speed="1" style="width: 300px; height: 300px" loop autoplay>
        </dotlottie-player>
    </div>


    <div id="logo-vanta" class="logo-container text-center py-3">
        <a href="{{ url('/') }}">
            <img src="{{ asset('storage/common-images/WhatsApp Image 2025-05-01 at 20.15.24_0501f586.jpg') }}"
                alt="CartMart Logo" class="main-logo">
        </a>
    </div>





    <!-- Navbar -->
    <nav id="main-navbar" class="navbar navbar-expand-md custom-navbar">
        <div class="container">
            <!-- Logo -->


            <!-- Toggler -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Navbar content -->
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto align-items-center">
                    @if (Auth::check() && Auth::user()->role == 'customer')
                        <li class="nav-item">
                            <a class="navbar-brand animated-border {{ request()->routeIs('recommended.cars') ? 'active-link' : '' }}"
                                href="{{ route('recommended.cars') }}">
                                <i class="bi bi-star-fill me-1"></i> Recommended
                            </a>
                        </li>
                    @endif

                    @guest
                        {{-- Guest users --}}
                    @else
                        @if (Auth::user()->role == 'admin')
                            <li class="nav-item">
                                <a class="navbar-brand animated-border {{ request()->is('admin_users*') ? 'active-link' : '' }}"
                                    href="{{ url('admin_users') }}">
                                    <i class="bi bi-shield-lock-fill me-1"></i> Admins
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="navbar-brand animated-border {{ request()->routeIs('brands.index') ? 'active-link' : '' }}"
                                    href="{{ route('brands.index') }}">
                                    <i class="bi bi-tags-fill me-1"></i> Brands
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="navbar-brand animated-border {{ request()->routeIs('analytics.index') ? 'active-link' : '' }}"
                                    href="{{ route('analytics.index') }}">
                                    <i class="bi bi-graph-up me-1"></i> Analytics
                                </a>
                            </li>
                        @else
                            <li class="nav-item">
                                <a class="navbar-brand animated-border {{ request()->routeIs('mypage') ? 'active-link' : '' }}"
                                    href="{{ route('mypage') }}">
                                    <i class="bi bi-card-list me-1"></i> My Listings
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="navbar-brand animated-border {{ request()->routeIs('cars.liked') ? 'active-link' : '' }}"
                                    href="{{ route('cars.liked') }}">
                                    <i class="bi bi-heart-fill me-1"></i> My Liked Cars
                                </a>
                            </li>
                            <li class="nav-item mx-3 position-relative">
                                <form class="search" action="{{ route('cars.index') }}" method="GET">
                                    <input type="text" name="q" class="textbox" placeholder="Search brands...">
                                    <button type="submit" class="icon d-flex justify-content-center align-items-center text-center">
                                        <i class="bi bi-search text-white"></i>
                                    </button>
                                </form>

                            </li>
                            <li class="nav-item">
                                <a class="navbar-brand animated-border {{ request()->routeIs('reservations.index') ? 'active-link' : '' }}"
                                    href="{{ route('reservations.index') }}">
                                    <i class="bi bi-calendar-check-fill me-1"></i> My Reserved Cars
                                </a>
                            </li>
                            <a class="navbar-brand animated-border {{ request()->routeIs('reservations.calendar') ? 'active-link' : '' }}"
                                href="{{ route('reservations.calendar') }}">
                                <i class="bi bi-calendar2-week-fill me-1"></i> Calendar View
                            </a>
                        @endif
                    @endguest

                    <li class="nav-item">
                        <a class="navbar-brand animated-border {{ request()->routeIs('policy') ? 'active-link' : '' }}"
                            href="{{ route('policy') }}">
                            <i class="bi bi-file-earmark-text-fill me-1"></i> Policies
                        </a>
                    </li>

                    @guest
                        @if (Route::has('login'))
                            <li class="nav-item">
                                <a class="navbar-brand animated-border {{ request()->routeIs('login') ? 'active-link' : '' }}"
                                    href="{{ route('login') }}">
                                    <i class="bi bi-box-arrow-in-right me-1"></i> {{ __('Login') }}
                                </a>
                            </li>
                        @endif
                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="navbar-brand animated-border {{ request()->routeIs('register') ? 'active-link' : '' }}"
                                    href="{{ route('register') }}">
                                    <i class="bi bi-person-plus-fill me-1"></i> {{ __('Register') }}
                                </a>
                            </li>
                        @endif
                    @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle text-white" href="#"
                                data-bs-toggle="dropdown" style="color: #00bcd4;">
                                <i style="color: #00bcd4"class="bi bi-person-circle me-1"></i>
                                {{ Auth::user()->name }}
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
            background: linear-gradient(135deg, #004d61, #1c1c1c, #007d8c);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
            height: 80px;
            z-index: 1000;
        }

        .navbar-brand {
            color: #f0f8ff;
            transition: all 0.3s ease;
        }

        .navbar-brand:hover {
            color: #ffffff;
        }

        .animated-border {
            position: relative;
            display: inline-block;
            color: #f0f8ff;
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
            background-color: #7de3ec;
            transition: 0.3s ease;
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

        .active-link {
            color: #00bcd4 !important;
            cursor: default;
        }

        .active-link::before,
        .active-link::after {
            width: 100% !important;
            background-color: #00bcd4 !important;
            transition: none !important;
        }

        .logo-container {
            background: linear-gradient(270deg, #004d61, #000000, #00bcd4, #000000);
            background-size: 1000% 1000%;
            animation: animatedGradient 15s ease infinite;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            position: relative;
            z-index: 1010;
        }

        .main-logo {
            max-height: 70px;
            border-radius: 14px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            box-shadow: 0 4px 12px rgba(0, 188, 212, 0.5);
        }

        .main-logo:hover {
            transform: scale(1.05);
            box-shadow: 0 6px 18px rgb(0, 238, 255);
        }

        .search {
            display: flex;
            align-items: center;
            padding: 6px;
            border-radius: 50px;
            background: transparent;
            transition: background 0.4s;
        }

        .search .textbox {
            width: 0;
            padding: 10px 16px;
            border: none;
            border-radius: 50px 0 0 50px;
            outline: none;
            background: transparent;
            color: white;
            transition: width 0.4s;
        }

        .search:hover {
            background: rgba(255, 255, 255, 0.1);
        }

        .search:hover .textbox {
            width: 150px;
            background: transparent;
        }

        .search .icon {
            background: #006aff;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            border: none;
            cursor: pointer;
        }

        .search-toggle-form {
            display: flex !important;
            align-items: center;
            gap: 0.5rem;
            /* optional spacing between elements */
        }

        .search-btn {
            height: 40px;
            padding: 0 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            line-height: 1;
        }







        /* Prevent content jumping when navbar becomes fixed */
    </style>

    <!-- Loader Hide Script -->
    <script>
        window.addEventListener('load', function() {
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
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const navbar = document.getElementById('main-navbar');
            const logoContainer = document.querySelector('.logo-container');
            const mainContent = document.querySelector('main');
            const logoHeight = logoContainer.offsetHeight;

            function updateNavbarState() {
                const scrollY = window.scrollY || window.pageYOffset;

                if (scrollY >= logoHeight) {
                    navbar.classList.add('fixed-top', 'navbar-fixed-top-shadow');
                    mainContent.style.marginTop = navbar.offsetHeight + 'px';
                } else {
                    navbar.classList.remove('fixed-top', 'navbar-fixed-top-shadow');
                    mainContent.style.marginTop = '0px';
                }
            }

            // Run once on page load
            updateNavbarState();

            // Run on scroll
            window.addEventListener('scroll', updateNavbarState);
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const searchBtn = document.querySelector(".search-btn");
            const searchWrapper = document.querySelector(".search-wrapper");
            const searchInput = document.querySelector(".search-input");
            const closeBtn = document.querySelector(".close-btn");
            const form = document.querySelector(".search-toggle-form");

            let active = false;

            searchBtn.addEventListener("click", function() {
                if (!active) {
                    searchWrapper.classList.add("active");
                    searchInput.focus();
                    active = true;
                } else {
                    if (searchInput.value.trim() !== "") {
                        form.submit(); // submit only if input is not empty
                    }
                }
            });

            closeBtn.addEventListener("click", function() {
                searchWrapper.classList.remove("active");
                searchInput.value = "";
                active = false;
            });
        });
    </script>
    <script>
document.addEventListener("DOMContentLoaded", function () {
    const searchBtn = document.querySelector(".search-btn");
    const searchWrapper = document.querySelector(".search-wrapper");
    const closeBtn = document.querySelector(".close-btn");
    const searchInput = document.querySelector(".search-input");

    if (searchBtn && searchWrapper && closeBtn) {
        // Toggle search bar open/close
        searchBtn.addEventListener("click", function (e) {
            e.preventDefault();
            searchWrapper.classList.toggle("active");

            if (searchWrapper.classList.contains("active")) {
                searchInput.focus();
            }
        });

        // Close search when "X" is clicked
        closeBtn.addEventListener("click", function () {
            searchWrapper.classList.remove("active");
        });

        // Optional: Close search if clicked outside
        document.addEventListener("click", function (e) {
            const isClickInside = searchWrapper.contains(e.target) || searchBtn.contains(e.target);
            if (!isClickInside) {
                searchWrapper.classList.remove("active");
            }
        });
    }
});
</script>




</body>

</html>
