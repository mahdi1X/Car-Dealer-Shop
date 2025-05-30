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


    <meta name="csrf-token" content="{{ csrf_token() }}">


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








    <!-- Navbar -->
    <nav id="main-navbar" class="navbar navbar-expand-md custom-navbar">
        <div class="container">
            <!-- Logo -->
            <div id="logo-vanta" class="logo-container text-center py-3">
                <a href="{{ url('/') }}">
                    <img src="{{ asset('storage/common-images/WhatsApp Image 2025-05-01 at 20.15.24_0501f586.jpg') }}"
                        alt="CartMart Logo" class="main-logo">
                </a>
            </div>
            <!-- Other nav links -->



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
                        @if (Auth::user()->role == 'admin' || Auth::user()->role == 'manager')
                            <li class="nav-item">
                                <a class="navbar-brand animated-border {{ request()->is('users.index*') ? 'active-link' : '' }}"
                                    href="{{ route('users.index') }}">

                                    <i class="bi bi-person-lines-fill me-1"></i> Users
                                </a>
                            </li>
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
                            <li class="nav-item">
                                <a class="navbar-brand animated-border {{ request()->routeIs('reports.index') ? 'active-link' : '' }}"
                                    href="{{ route('reports.index') }}">
                                    <i class="bi bi-exclamation-triangle"></i>User Reports
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
                            <a id="navbarDropdown" class="nav-link dropdown-toggle d-flex align-items-center text-white"
                                href="#" data-bs-toggle="dropdown" style="color: #00bcd4;">
                                @if (Auth::user()->profile_picture)
                                    <img src="{{ asset('storage/' . Auth::user()->profile_picture) }}"
                                        class="rounded-circle me-2" width="30" height="30" alt="Profile">
                                @else
                                    <i class="bi bi-person-circle me-1" style="font-size: 1.4rem; color: #00bcd4;"></i>
                                @endif
                                {{ Auth::user()->name }}
                            </a>

                            <div class="dropdown-menu dropdown-menu-end">
                                {{-- Profile link --}}
                                <a class="dropdown-item" href="{{ route('user.profile', Auth::user()->id) }}">
                                    {{ __('Profile') }}
                                </a>

                                {{-- Logout link --}}
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


    @if (Auth::check() && Auth::user()->role == 'customer')
        <div class="search-wrapper">
            <form class="search" action="{{ route('cars.index') }}" method="GET">
                <input type="text" name="q" class="textbox" placeholder="Search brands...">
                <button type="submit" class="icon d-flex justify-content-center align-items-center text-center">
                    <i class="bi bi-search text-white"></i>
                </button>
            </form>
        </div>
    @endif


    <!-- Main Content -->
    <main class="py-0" style="margin-top: 80px;">
        @yield('content')
    </main>
    </div>

    <!-- Custom Styles -->
    <style>
        /* Navbar Enhancements */
        /* Add this in your CSS or in a style tag */
        .navbar-bg {
            @apply bg-white/70 backdrop-blur-md shadow-md transition-colors duration-300;
        }

        .custom-navbar {
            background: rgba(118, 118, 118, 0.8);
            /* stronger, consistent */
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            box-shadow: 0 6px 30px rgba(0, 188, 212, 0.3);
            transition: background 0.3s ease, backdrop-filter 0.3s ease, box-shadow 0.3s ease;
        }


        .navbar-brand {
            color: #ffffff;
            font-family: 'Ubuntu', sans-serif;
            font-size: 1rem;
            padding: 6px 12px;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .navbar-brand:hover {
            background: rgba(0, 188, 212, 0.1);
            color: #00e0ff;
        }

        .animated-border {
            position: relative;
        }

        .animated-border::before,
        .animated-border::after {
            content: '';
            position: absolute;
            height: 2px;
            width: 0;
            background-color: #00e0ff;
            transition: width 0.3s ease;
        }

        .animated-border::before {
            left: 0;
            bottom: 0;
        }

        .animated-border::after {
            right: 0;
            top: 0;
        }

        .animated-border:hover::before,
        .animated-border:hover::after {
            width: 100%;
        }

        .active-link {
            color: #00e0ff !important;
            font-weight: 600;
        }

        .active-link::before,
        .active-link::after {
            width: 100%;
            background-color: #00e0ff;
        }

        .logo-container {
            padding: 10px 0;
            box-shadow: 0 4px 10px rgba(0, 188, 212, 0.1);
        }

        .main-logo {
            max-height: 75px;
            border-radius: 12px;
            transition: all 0.4s ease;
            box-shadow: 0 0 15px rgba(0, 225, 255, 0.4);
        }

        .main-logo:hover {
            transform: scale(1.03);
            box-shadow: 0 0 25px rgb(0, 255, 255);
        }

        .search {
            display: flex;
            align-items: center;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 30px;
            padding: 4px;
            transition: all 0.3s ease;
        }

        .search-wrapper {
            position: fixed;
            top: 150px;
            /* or match your navbar height */
            right: 45px;
            z-index: 1000;
            background-color: transparent;
            backdrop-filter: none;
            padding: 0;
            display: flex;
            justify-content: flex-end;
        }


        /* Optional: adapt width & style of form inside */
        .search {
            display: flex;
            align-items: center;
        }

        .search .textbox {
            border: none;
            padding: 6px 12px;
            border-radius: 4px 0 0 4px;
            outline: none;
        }

        .search .icon {
            background-color: #005ec2;
            border: none;
            padding: 30px 30px;
            border-radius: 0 4px 4px 0;
            cursor: pointer;
        }




        .search:hover {
            background: rgb(135, 135, 135);
        }

        .search .textbox {
            width: 0;
            padding: 10px 0;
            background: transparent;
            border: none;
            outline: none;
            color: #ffffff;
            transition: width 0.4s ease;
            font-size: 0.9rem;
        }

        .search:hover .textbox {
            width: 250px;
            padding: 10px 12px;
        }

        .search .icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #00bcd4;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background 0.3s ease;
        }

        .search .icon:hover {
            background: #00e0ff;
        }

        /* Dropdown User Profile Enhancements */
        .dropdown-toggle {
            font-weight: 500;
            color: #ffffff;
            font-size: 1rem;
            transition: color 0.3s ease;
        }

        .dropdown-toggle:hover {
            color: #00e0ff;
        }

        .dropdown-menu {
            background: #555555;
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        .dropdown-item {
            color: #ffffff;
            transition: background 0.2s ease;
        }

        .dropdown-item:hover {
            background-color: #00bcd4;
            color: #ffffff;
        }

        /* Navbar Shadow When Fixed */
        .navbar-fixed-top-shadow {
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.3);
        }
    </style>
    <script>
        window.addEventListener('DOMContentLoaded', () => {
            const navbar = document.getElementById('navbar_top');
            const searchWrapper = document.querySelector('.search-wrapper');

            if (navbar && searchWrapper) {
                const navHeight = navbar.offsetHeight;
                searchWrapper.style.top = navHeight + 'px';
            }
        });
    </script>

    <script>
        const searchBar = document.querySelector('.search-bar-fixed');

        function updateNavbarState() {
            const scrollY = window.scrollY || window.pageYOffset;

            if (scrollY >= logoHeight) {
                navbar.classList.add('fixed-top', 'navbar-fixed-top-shadow');
                searchBar.style.top = navbar.offsetHeight + 'px';
            } else {
                navbar.classList.remove('fixed-top', 'navbar-fixed-top-shadow');
                searchBar.style.top = '80px'; // fallback default
            }
        }
    </script>
    <script>
        const navbar = document.getElementById('main-navbar');

        window.addEventListener('scroll', () => {
            if (window.scrollY > 20) {
                // Scrolled down — slightly stronger blur + background
                navbar.style.background = 'rgba(146, 138, 138, 0.8)';
                navbar.style.backdropFilter = 'blur(12px)';
                navbar.style.webkitBackdropFilter = 'blur(12px)';
                navbar.style.boxShadow = '0 6px 30px rgba(0, 188, 212, 0.3)';
            } else {
                // At the very top — gentle blur + background
                navbar.style.background = 'rgba(146, 138, 138, 0.6)';
                navbar.style.backdropFilter = 'blur(10px)';
                navbar.style.webkitBackdropFilter = 'blur(10px)';
                navbar.style.boxShadow = '0 4px 20px rgba(0, 188, 212, 0.2)';
            }
        });
    </script>

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
        document.addEventListener("DOMContentLoaded", function() {
            const searchBtn = document.querySelector(".search-btn");
            const searchWrapper = document.querySelector(".search-wrapper");
            const closeBtn = document.querySelector(".close-btn");
            const searchInput = document.querySelector(".search-input");

            if (searchBtn && searchWrapper && closeBtn) {
                // Toggle search bar open/close
                searchBtn.addEventListener("click", function(e) {
                    e.preventDefault();
                    searchWrapper.classList.toggle("active");

                    if (searchWrapper.classList.contains("active")) {
                        searchInput.focus();
                    }
                });

                // Close search when "X" is clicked
                closeBtn.addEventListener("click", function() {
                    searchWrapper.classList.remove("active");
                });

                // Optional: Close search if clicked outside
                document.addEventListener("click", function(e) {
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
