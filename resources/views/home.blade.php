@extends('layouts.app')

@section('content')
    <!-- Carousel Start -->
    <div class="container-fluid p-0 mb-5">

        <div id="header-carousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                @foreach ([['bg' => 'carousel-bg-1.jpg', 'img' => 'carousel-1.png', 'title' => 'List and Buy Cars'], ['bg' => 'carousel-bg-2.jpg', 'img' => 'carousel-2.png', 'title' => 'Display Your Cars Under Variety Of Brands']] as $index => $slide)
                    <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                        <img class="w-100" src="img/{{ $slide['bg'] }}" alt="Image">
                        <div class="carousel-caption d-flex align-items-center">
                            <div class="container">
                                <div class="row align-items-center justify-content-center justify-content-lg-start">
                                    <div class="col-10 col-lg-7 text-center text-lg-start">
                                        <h1 class="display-3 text-white mb-4 pb-3 animated slideInDown">
                                            {{ $slide['title'] }}</h1>
                                    </div>
                                    <div class="col-lg-5 d-none d-lg-flex animated zoomIn">
                                        <img class="img-fluid" src="img/{{ $slide['img'] }}" alt="">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#header-carousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#header-carousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>
    <div class="container my-5">
        <div class="row align-items-center flex-md-row flex-column-reverse">
            <!-- Text Section (Left) -->
            <div class="col-md-6">
                <div class="p-4 shadow rounded-4 border border-primary-subtle" style="background-color: #f8fafc;">
                    <h3 class="mb-3 fw-bold">Welcome to Carmart</h3>
                    <p class="mb-0" style="font-size: 1.1rem; color: #333;">
                        Explore a wide range of cars for sale, from luxury brands to everyday vehicles. Whether you're
                        looking to buy or sell, Carmart is your go-to platform for all things automotive.
                    </p>
                </div>
            </div>
            <!-- Image Section (Right) -->
            <div class="col-md-6">
                <div class="position-relative w-100" style="max-height: 1000px; overflow: hidden;">
                    <img src="img/3d-lebanon-removebg.png" class="img-fluid w-100" alt="Map of Lebanon"
                        style="max-height: 1000px; object-fit: contain;">

                    @php
                        $regions = [
                            'Beirut',
                            'Mount Lebanon',
                            'North Lebanon',
                            'South Lebanon',
                            'Nabatieh',
                            'Bekaa',
                            'Baalbek-Hermel',
                            'Akkar',
                        ];

                        $positions = [
                            ['top' => '45%', 'left' => '20%'], // Beirut
                            ['top' => '43%', 'left' => '35%'], // Mount Lebanon
                            ['top' => '15%', 'left' => '50%'], // North Lebanon
                            ['top' => '70%', 'left' => '15%'], // South Lebanon
                            ['top' => '60%', 'left' => '35%'], // Nabatieh
                            ['top' => '50%', 'left' => '61%'], // Bekaa
                            ['top' => '30%', 'left' => '65%'], // Baalbek-Hermel
                            ['top' => '25%', 'left' => '40%'], // Akkar
                        ];

                        $regionColors = [
                            '#007bff',
                            '#6610f2',
                            '#6f42c1',
                            '#20c997',
                            '#fd7e14',
                            '#e83e8c',
                            '#17a2b8',
                            '#28a745',
                        ];
                    @endphp

                    @foreach ($regions as $index => $region)
                        <div class="region-marker position-absolute d-flex align-items-center justify-content-center"
                            style="
                     top: {{ $positions[$index]['top'] }};
                     left: {{ $positions[$index]['left'] }};
                     background-color: {{ $regionColors[$index % count($regionColors)] }};
                 ">
                            <span class="me-2" style="font-size: 1.2em;">&#9679;</span>
                            {{ $region }}
                        </div>
                    @endforeach
                </div>
            </div>

            <style>
                .region-marker {
                    color: #fff;
                    font-weight: 600;
                    font-size: 1rem;
                    padding: 8px 18px;
                    border-radius: 24px;
                    box-shadow: 0 2px 12px rgba(0, 0, 0, 0.13);
                    cursor: pointer;
                    transition: transform 0.2s ease, box-shadow 0.2s ease, background 0.2s ease;
                    border: 2px solid #fff;
                    z-index: 2;
                    white-space: nowrap;
                }

                .region-marker:hover {
                    background-color: #222 !important;
                    color: #fff !important;
                    border-color: #007bff !important;
                    box-shadow: 0 6px 24px rgba(0, 0, 0, 0.22) !important;
                    transform: scale(1.09);
                }

                @media (max-width: 768px) {
                    .region-marker {
                        font-size: 0.85rem;
                        padding: 6px 12px;
                    }
                }
            </style>




            <!-- Call to Action -->
            <div class="container my-5 text-center">
                <a href="{{ route('cars.index') }}" class="btn btn-primary btn-lg mx-2 btn-interactive">
                    <i class="fa fa-search me-2"></i>Browse Cars
                </a>
                <a href="{{ route('register') }}" class="btn btn-outline-light btn-lg mx-2 bg-dark btn-interactive">
                    <i class="fa fa-user-plus me-2"></i>Become a Dealer
                </a>
            </div>

            <!-- Services Section -->
            <div class="container-xxl py-5">
                <div class="container">
                    <div class="row g-4">
                        @foreach ([['icon' => 'fa-certificate', 'title' => 'Quality Servicing', 'desc' => 'Top-notch car hosting services.'], ['icon' => 'fa-users-cog', 'title' => 'Fast Response', 'desc' => 'Instant access to your reserved car.'], ['icon' => 'fa-tools', 'title' => 'You are the controller', 'desc' => 'Full flexibility on time and pickup.']] as $i => $service)
                            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="{{ 0.1 + $i * 0.2 }}s">
                                <div class="d-flex service-card py-5 px-4">
                                    <i class="fa {{ $service['icon'] }} fa-3x text-primary flex-shrink-0"></i>
                                    <div class="ps-4">
                                        <h5 class="mb-3">{{ $service['title'] }}</h5>
                                        <p>{{ $service['desc'] }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Stats Section -->
            <div class="container-fluid fact bg-dark my-5 py-5">
                <div class="container">
                    <div class="row g-4 text-center text-white">
                        @foreach ([['icon' => 'fa-check', 'count' => '12', 'label' => 'Years Experience'], ['icon' => 'fa-users-cog', 'count' => '30', 'label' => 'Expert Technicians'], ['icon' => 'fa-users', 'count' => '+12k', 'label' => 'Satisfied Clients'], ['icon' => 'fa-car', 'count' => '15633', 'label' => 'Sold Cars']] as $i => $fact)
                            <div class="col-md-6 col-lg-3 wow fadeIn" data-wow-delay="{{ 0.1 + $i * 0.2 }}s">
                                <i class="fa {{ $fact['icon'] }} fa-2x mb-3"></i>
                                <h2 class="mb-2" data-toggle="counter-up">{{ $fact['count'] }}</h2>
                                <p class="mb-0">{{ $fact['label'] }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Car Brands Section -->
            <div class="container-xxl service py-5">
                <div class="container">
                    <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                        <h1 class="mb-5">Explore Many Cars For Sale</h1>
                    </div>
                    <div class="row g-4 wow fadeInUp" data-wow-delay="0.3s">
                        <div class="col-lg-4">
                            <div class="nav nav-pills flex-column nav-fill">
                                @foreach (['Mercedes', 'BMW', 'Audi', 'Volkswagen'] as $i => $brand)
                                    <button
                                        class="nav-link d-flex align-items-center text-start p-4 mb-3 {{ $i == 0 ? 'active' : '' }}"
                                        data-bs-toggle="pill" data-bs-target="#tab-pane-{{ $i + 1 }}">
                                        <i class="fa fa-car fa-2x me-3"></i>
                                        <h4 class="m-0">{{ $brand }}</h4>
                                    </button>
                                @endforeach
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div class="tab-content">
                                @foreach (['mercedes', 'bmw', 'audi', 'volkswagen'] as $i => $brand)
                                    <div class="tab-pane fade {{ $i == 0 ? 'show active' : '' }}"
                                        id="tab-pane-{{ $i + 1 }}">
                                        <div class="row g-4">
                                            <div class="col-md-6" style="min-height: 350px;">
                                                <div class="position-relative h-100">
                                                    <img class="position-absolute img-fluid w-100 h-100"
                                                        src="img/{{ $brand }}.jpg" style="object-fit: cover;"
                                                        alt="">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <h3 class="mb-3">Trusted Expertise in {{ ucfirst($brand) }}</h3>
                                                <p class="mb-4">Browse cars from your favorite brand with quality
                                                    assurance and
                                                    full control.</p>
                                                <p><i class="fa fa-check text-success me-3"></i>Certified Listings</p>
                                                <p><i class="fa fa-check text-success me-3"></i>Verified Dealers</p>
                                                <p><i class="fa fa-check text-success me-3"></i>Secure Transactions</p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Testimonials -->
            <div class="container-xxl py-5 wow fadeInUp" data-wow-delay="0.1s">
                <div class="container">
                    <div class="owl-carousel testimonial-carousel position-relative">
                        @foreach ([1, 2, 3, 4] as $n)
                            <div class="testimonial-item text-center">
                                <img class="bg-light rounded-circle p-2 mx-auto mb-3"
                                    src="img/testimonial-{{ $n }}.jpg" style="width: 80px; height: 80px;">
                                <h5 class="mb-0">Client Name</h5>
                                <p>Profession</p>
                                <div class="testimonial-text bg-light text-center p-4">
                                    <p class="mb-0">Excellent experience! Seamless process and great selection of cars.
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="container-fluid bg-dark text-light footer pt-5 mt-5 wow fadeIn" data-wow-delay="0.1s">
                <div class="container py-5">
                    <div class="row g-5">
                        <div class="col-lg-3 col-md-6">
                            <h4 class="text-light mb-4">Address</h4>
                            <p><i class="fa fa-map-marker-alt me-3"></i>Beirut, Dahye, Laylake</p>
                            <p><i class="fa fa-phone-alt me-3"></i>+961 76 03 66 89</p>
                            <p><i class="fa fa-envelope me-3"></i>10121525@mu.ed.lb.com</p>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <h4 class="text-light mb-4">Opening Hours</h4>
                            <h6 class="text-light">Monday - Friday:</h6>
                            <p>09.00 AM - 09.00 PM</p>
                            <h6 class="text-light">Saturday - Sunday:</h6>
                            <p>Closed</p>
                        </div>
                    </div>
                </div>
                <div class="container text-center">
                    <p class="mb-0 text-light">&copy; {{ date('Y') }} Carmart. All Rights Reserved.</p>
                </div>
            </div>
        @endsection

        @push('styles')
            <style>
                .btn-interactive {
                    transition: all 0.3s ease;
                }

                .btn-interactive:hover {
                    transform: scale(1.05);
                    box-shadow: 0 0 10px rgba(0, 123, 255, 0.5);
                }

                .service-card {
                    background: rgba(255, 255, 255, 0.15);
                    border-radius: 16px;
                    backdrop-filter: blur(10px);
                    border: 1px solid rgba(255, 255, 255, 0.1);
                    box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
                }
            </style>
        @endpush
