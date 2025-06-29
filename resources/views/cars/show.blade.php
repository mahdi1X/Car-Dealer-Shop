@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <div class="card shadow-lg border-0 modern-form-card mb-5" style="border-radius: 22px;">
            <div class="card-body">
                <h1 class="mb-4 text-center fancy-title">{{ $car->name ?? 'Unnamed Car' }}</h1>
                {{-- Brand Icon Fixed Button --}}
                @if ($car->brand && $car->brand->icon)
                    <a href="{{ route('brands.show', $car->brand->id) }}"
                       class="brand-icon-btn"
                       style="position: fixed; bottom: 30px; left: 30px; z-index: 1001; display: flex; align-items: center; background: #fff; border-radius: 50%; box-shadow: 0 4px 16px rgba(75,139,145,0.13); width: 70px; height: 70px; justify-content: center; border: 2.5px solid #e0e7ef; transition: box-shadow 0.2s, transform 0.2s;">
                        <img src="{{ asset('storage/' . $car->brand->icon) }}"
                             alt="{{ $car->brand->name }}"
                             style="max-width: 48px; max-height: 48px; object-fit: contain;">
                    </a>
                @endif

                <div class="row g-4">
                    <div class="col-md-6">
                        @if ($car->image)
                            <div class="text-center mb-4">
                                <img src="{{ asset('storage/' . $car->image) }}" alt="{{ $car->name }}" class="img-fluid rounded shadow"
                                    style="max-height: 350px;">
                            </div>
                        @endif

                        {{-- Gallery --}}
                        <div class="mb-4">
                            <h5 class="mb-2 text-primary">Gallery</h5>
                            @php
                                $gallery = is_array($car->gallery_images) ? $car->gallery_images : (json_decode($car->gallery_images, true) ?: []);
                            @endphp
                            @if (!empty($gallery) && is_array($gallery))
                                <div style="overflow-x: auto; white-space: nowrap; padding-bottom: 10px;">
                                    @foreach ($gallery as $index => $image)
                                        <img src="{{ asset('storage/' . $image) }}" alt="Gallery Image"
                                            style="height: 90px; width: auto; display: inline-block; margin-right: 10px; border-radius: 5px; box-shadow: 0 2px 6px rgba(0,0,0,0.2); cursor: pointer;"
                                            onclick="openFullscreen('{{ asset('storage/' . $image) }}')" />
                                    @endforeach
                                </div>
                            @else
                                <p class="text-muted">No gallery images available.</p>
                            @endif
                        </div>

                        {{-- Documents --}}
                        @if ($car->documents)
                            <div class="mb-4">
                                <h5 class="text-muted">Documents</h5>
                                <ul class="list-unstyled">
                                    @foreach (is_array($car->documents) ? $car->documents : (json_decode($car->documents, true) ?: []) as $document)
                                        <li>
                                            <a href="{{ asset('storage/' . $document) }}" target="_blank" class="text-primary">
                                                <i class="bi bi-file-earmark-text me-1"></i>{{ basename($document) }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        {{-- Video --}}
                        @if ($car->video)
                            <div class="mb-4">
                                <h5 class="text-muted">Video</h5>
                                <video controls class="w-100 rounded shadow-sm" style="max-height: 220px;">
                                    <source src="{{ asset('storage/' . $car->video) }}" type="video/mp4">
                                    Your browser does not support the video tag.
                                </video>
                            </div>
                        @endif
                    </div>
                    <div class="col-md-6">
                        {{-- Car Info --}}
                        <div class="p-3 border rounded shadow-sm bg-light mb-4">
                            <h5 class="mb-3 text-primary">Car Details</h5>
                            <p><strong>Brand:</strong> {{ $car->brand->name ?? 'N/A' }}</p>
                            <p><strong>Color:</strong> {{ $car->color ?? 'N/A' }}</p>
                            <p><strong>Year:</strong> {{ $car->year ?? 'N/A' }}</p>
                            <p><strong>Price:</strong> ${{ number_format($car->price ?? 0, 2) }}</p>
                            <p><strong>KM Recorded:</strong> {{ $car->km_recorded ?? 'N/A' }} km</p>
                            <p><strong>Length:</strong> {{ $car->length ?? 'N/A' }} m</p>
                            <p><strong>Fuel Type:</strong> {{ $car->fuel_type ?? 'N/A' }}</p>
                            <p><strong>Transmission:</strong> {{ $car->transmission ?? 'N/A' }}</p>
                            <p><strong>Engine Type:</strong> {{ $car->engine_type ?? 'N/A' }}</p>
                            <p><strong>Engine Size:</strong> {{ $car->engine_size ?? 'N/A' }}</p>
                            <p><strong>Horsepower:</strong> {{ $car->horsepower ?? 'N/A' }}</p>
                            <p><strong>Torque:</strong> {{ $car->torque ?? 'N/A' }}</p>
                            <p><strong>Drivetrain:</strong> {{ $car->drivetrain ?? 'N/A' }}</p>
                            <p><strong>Fuel Economy:</strong> {{ $car->fuel_economy ?? 'N/A' }}</p>
                        </div>
                        <div class="p-3 border rounded shadow-sm bg-light">
                            <h5 class="mb-3 text-success">Other Details</h5>
                            <p><strong>Body Type:</strong> {{ $car->body_type ?? 'N/A' }}</p>
                            <p><strong>Seats:</strong> {{ $car->seats ?? 'N/A' }}</p>
                            <p><strong>Doors:</strong> {{ $car->doors ?? 'N/A' }}</p>
                            <p><strong>Interior Color:</strong> {{ $car->interior_color ?? 'N/A' }}</p>
                            <p><strong>Safety Rating:</strong> {{ $car->safety_rating ?? 'N/A' }}</p>
                            <p><strong>Condition:</strong> {{ $car->condition ?? 'N/A' }}</p>
                            <p><strong>Service History:</strong> {{ $car->service_history ?? 'N/A' }}</p>
                            <p><strong>Accident History:</strong> {{ $car->accident_history ?? 'N/A' }}</p>
                            <p><strong>Ownership Count:</strong> {{ $car->ownership_count ?? 'N/A' }}</p>
                            <p><strong>Registration Valid Till:</strong> {{ $car->registration_valid_till ?? 'N/A' }}</p>
                            <p><strong>Location:</strong> {{ $car->location ?? 'N/A' }}</p>
                            <p><strong>Delivery Available:</strong> {{ $car->delivery_available ? 'Yes' : 'No' }}</p>
                            <p><strong>Available From:</strong> {{ $car->available_from ?? 'N/A' }}</p>
                            @php
                                $features = json_decode($car->features, true) ?: [];
                            @endphp
                            @if (count($features) > 0)
                                <p><strong>Features:</strong></p>
                                <ul>
                                    @foreach ($features as $feature)
                                        <li>{{ $feature }}</li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Like Button --}}
                @php
                    $liked =
                        auth()->check() &&
                        $car
                            ->likes()
                            ->where('user_id', auth()->id())
                            ->where('like', 1)
                            ->exists();
                    $likesCount = $car->likes()->count();
                @endphp

                <div class="mt-4 text-center">
                    @if (auth()->check())
                        <form id="likeForm" action="{{ route('like.toggle') }}" method="POST" class="d-inline-block" onsubmit="return false;">
                            @csrf
                            <input type="hidden" name="car_id" value="{{ $car->id }}">
                            <input type="hidden" name="like" value="1">
                            <button type="button" id="likeButton" class="like-btn {{ $liked ? 'liked' : '' }}"
                                aria-pressed="{{ $liked ? 'true' : 'false' }}" aria-label="Toggle Like" onclick="toggleLike()">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon thumbs-up-icon"
                                    fill="{{ $liked ? '#3b82f6' : '#9ca3af' }}" viewBox="0 0 24 24" stroke="none">
                                    <path
                                        d="M2 20h2v-9H2v9zm19-11h-6.31l.95-4.57.03-.32a.996.996 0 0 0-.29-.7L14.17 2 7.59 8.59C7.22 8.95 7 9.45 7 10v9c0 1.1.9 2 2 2h7c.83 0 1.54-.5 1.84-1.22l3.02-7.05c.09-.23.14-.47.14-.73v-1c0-1.1-.9-2-2-2z" />
                                </svg>
                                <span id="likesCount" class="likes-count">{{ $likesCount }}</span>
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-outline-primary">
                            Log in to like this car ({{ $likesCount }} likes)
                        </a>
                    @endif
                </div>

                {{-- Owner --}}
                <div class="flex justify-center mt-5">
                    <a href="{{ route('user.profile', $car->createdBy->id) }}"
                        class="block bg-gradient-to-r from-white to-gray-50 hover:from-indigo-50 hover:to-indigo-100 transition-all shadow-md rounded-xl px-6 py-4 text-center max-w-xs border border-gray-200 hover:border-indigo-400"
                        title="View owner details">
                        <h5 class="text-lg font-semibold text-gray-700">
                            <span class="text-gray-500">Owned By:</span>
                            <span class="text-indigo-600 hover:underline">{{ $car->createdBy->name }}</span>
                        </h5>
                    </a>
                </div>

                {{-- Reserve Button (if not car owner) --}}
                @if (Auth::check() && $car->created_by_id != Auth::id())
                    <button class="fixed-button btn btn-primary" @if ($isReserved) disabled @endif
                        @if ($isReserved) style="cursor: not-allowed;" @endif   
                        onclick="window.location.href='{{ route('reservations.create', ['car' => $car->id]) }}'">
                        @if ($isReserved)
                            Already Reserved
                        @else
                            Reserve Now
                        @endif
                    </button>
                @endif

                <!-- Fullscreen Modal -->
                <div id="fullscreenModal"
                    style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.9); justify-content:center; align-items:center; z-index:1000;">
                    <img id="fullscreenImage" src="" alt="Fullscreen Image"
                        style="max-width:90%; max-height:90%; border-radius: 8px; box-shadow: 0 0 20px rgba(255,255,255,0.5);" />
                    <span style="position:absolute; top:20px; right:30px; font-size:40px; color:white; cursor:pointer;"
                        onclick="closeFullscreen()">&times;</span>
                </div>
            </div>
        </div>
        <style>
            .modern-form-card {
                background: linear-gradient(120deg, #f8fafc 80%, #e0f7fa 100%);
                border-radius: 22px;
                box-shadow: 0 8px 32px rgba(75,139,145,0.10), 0 2px 8px rgba(0,0,0,0.04);
                margin-bottom: 32px;
            }
            .fancy-title {
                font-family: 'Barlow', sans-serif;
                font-weight: 700;
                font-size: 2.2rem;
                color: #4b8b91;
                border-bottom: 3px solid #4b8b91;
                display: inline-block;
                padding-bottom: 8px;
                margin-bottom: 24px;
            }
            .brand-icon-btn {
                background: linear-gradient(135deg, #f8fafc 70%, #e0f7fa 100%);
                box-shadow: 0 4px 24px rgba(75,139,145,0.13), 0 2px 8px rgba(0,0,0,0.04);
                border: 2.5px solid #e0e7ef;
                border-radius: 50%;
                transition: box-shadow 0.2s, transform 0.2s, border-color 0.2s;
                display: flex;
                align-items: center;
                justify-content: center;
                width: 70px;
                height: 70px;
                position: fixed;
                bottom: 30px;
                left: 30px;
                z-index: 1001;
            }
            .brand-icon-btn:hover {
                box-shadow: 0 8px 32px rgba(75,139,145,0.18), 0 4px 16px rgba(0,0,0,0.10);
                transform: scale(1.08) rotate(-6deg);
                border-color: #4b8b91;
                background: linear-gradient(135deg, #e0f7fa 60%, #f8fafc 100%);
            }
            .brand-icon-btn img {
                max-width: 48px;
                max-height: 48px;
                object-fit: contain;
                filter: drop-shadow(0 2px 6px rgba(75,139,145,0.10));
                transition: filter 0.2s;
            }
            @media (max-width: 767.98px) {
                .brand-icon-btn {
                    bottom: 16px !important;
                    left: 10px !important;
                    width: 54px !important;
                    height: 54px !important;
                }
                .brand-icon-btn img {
                    max-width: 36px !important;
                    max-height: 36px !important;
                }
            }
            .like-btn {
                display: inline-flex;
                align-items: center;
                gap: 12px;
                font-weight: 600;
                font-size: 1.5rem;
                color: #9ca3af;
                background: transparent;
                border: none;
                cursor: pointer;
                transition: color 0.3s ease, transform 0.2s ease;
                user-select: none;
                padding: 8px 16px;
                border-radius: 8px;
            }
            .like-btn:hover:not(.liked) {
                color: #3b82f6;
                transform: scale(1.1);
            }
            .like-btn.liked {
                color: #3b82f6;
                transform: scale(1.25);
                transition: color 0.4s ease, transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
            }
            .icon {
                width: 48px;
                height: 48px;
                transition: fill 0.3s ease;
            }
            .likes-count {
                min-width: 32px;
                text-align: left;
                color: inherit;
                transition: color 0.3s ease;
            }
            .fixed-button {
                position: fixed;
                bottom: 20px;
                right: 20px;
                z-index: 1000;
                padding: 10px 20px;
                border-radius: 5px;
                text-decoration: none;
            }
        </style>
        <script>
            function openFullscreen(src) {
                const modal = document.getElementById('fullscreenModal');
                const img = document.getElementById('fullscreenImage');
                img.src = src;
                modal.style.display = 'flex';
            }
            function closeFullscreen() {
                document.getElementById('fullscreenModal').style.display = 'none';
                document.getElementById('fullscreenImage').src = '';
            }
            document.getElementById('fullscreenModal').addEventListener('click', function(e) {
                if (e.target === this) {
                    closeFullscreen();
                }
            });
            function toggleLike() {
                const form = document.getElementById('likeForm');
                const button = document.getElementById('likeButton');
                const likesCountSpan = document.getElementById('likesCount');
                const url = form.action;
                const token = form.querySelector('input[name="_token"]').value;
                const carId = form.querySelector('input[name="car_id"]').value;
                const like = form.querySelector('input[name="like"]').value;
                // Optimistic UI update
                const wasLiked = button.classList.contains('liked');
                let likesCount = parseInt(likesCountSpan.textContent, 10) || 0;
                if (wasLiked) {
                    button.classList.remove('liked');
                    button.setAttribute('aria-pressed', 'false');
                    button.querySelector('svg').setAttribute('fill', '#9ca3af');
                    likesCountSpan.textContent = Math.max(0, likesCount - 1);
                } else {
                    button.classList.add('liked');
                    button.setAttribute('aria-pressed', 'true');
                    button.querySelector('svg').setAttribute('fill', '#3b82f6');
                    likesCountSpan.textContent = likesCount + 1;
                }
                fetch(url, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': token,
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            car_id: carId,
                            like: like
                        })
                    })
                    .then(async response => {})
                    .catch((err) => {});
            }
        </script>
    </div>
@endsection
