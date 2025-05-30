@extends('layouts.app')

@section('content')
    <!-- Carousel Start -->
    <div class="container-fluid p-0 mb-5">
        <div id="header-carousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img class="w-100" src="img/carousel-bg-1.jpg" alt="Image">
                    <div class="carousel-caption d-flex align-items-center">
                        <div class="container">
                            <div class="row align-items-center justify-content-center justify-content-lg-start">
                                <div class="col-10 col-lg-7 text-center text-lg-start">
                                    <h1 class="display-3 text-white mb-4 pb-3 animated slideInDown">List and Buy Cars</h1>
                                </div>
                                <div class="col-lg-5 d-none d-lg-flex animated zoomIn">
                                    <img class="img-fluid" src="img/carousel-1.png" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <img class="w-100" src="img/carousel-bg-2.jpg" alt="Image">
                    <div class="carousel-caption d-flex align-items-center">
                        <div class="container">
                            <div class="row align-items-center justify-content-center justify-content-lg-start">
                                <div class="col-10 col-lg-7 text-center text-lg-start">
                                    <h1 class="display-3 text-white mb-4 pb-3 animated slideInDown">Display Your Cars Under
                                        Variety Of Brands</h1>
                                </div>
                                <div class="col-lg-5 d-none d-lg-flex animated zoomIn">
                                    <img class="img-fluid" src="img/carousel-2.png" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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
    <div class="container my-5 text-center">
        <a href="{{ route('cars.index') }}" class="btn btn-primary btn-lg mx-2 btn-interactive">
            Browse Cars
        </a>
        <a href="{{ route('register') }}" class="btn btn-outline-light btn-lg mx-2 bg-dark btn-interactive">
            Become a Dealer
        </a>
    </div>


    <!-- Carousel End -->

    <!-- Services Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="row g-4">
                @foreach ([['icon' => 'fa-certificate', 'title' => 'Quality Servicing', 'desc' => 'The best dealer shop that offers car hosting for sale'], ['icon' => 'fa-users-cog', 'title' => 'Fast Response', 'desc' => 'After your reservation there is no need for waiting. Go and receive the car on your chosen date'], ['icon' => 'fa-tools', 'title' => 'You are the controller', 'desc' => 'You have full freedom in choosing the time of receiving']] as $i => $service)
                    <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="{{ 0.1 + $i * 0.2 }}s">
                        <div class="d-flex {{ $i === 1 ? 'bg-light' : '' }} py-5 px-4">
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
    <!-- Services End -->

    <!-- Fact Start -->
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
    <!-- Fact End -->

    <!-- Car Brands Showcase Start -->
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
                                        <h3 class="mb-3">12 Years Of Experience In Commercial Mediation</h3>
                                        <p class="mb-4">Everything you need to know about global cars</p>
                                        <p><i class="fa fa-check text-success me-3"></i>Quality Servicing</p>
                                        <p><i class="fa fa-check text-success me-3"></i>Fast Response</p>
                                        <p><i class="fa fa-check text-success me-3"></i>You are the controller</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Car Brands Showcase End -->

    <!-- Testimonials Start -->
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
                            <p class="mb-0">Tempor erat elitr rebum at clita. Diam dolor diam ipsum sit diam amet diam et
                                eos.</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <!-- Testimonials End -->

    <!-- Footer Start -->
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
                <!-- Add additional footer sections if needed -->
            </div>
        </div>
        <div class="container text-center">
            <p class="mb-0 text-light">&copy; {{ date('Y') }} YourCarSite. All Rights Reserved.</p>
        </div>
    </div>
    <!-- Footer End -->
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
    </style>
@endpush
