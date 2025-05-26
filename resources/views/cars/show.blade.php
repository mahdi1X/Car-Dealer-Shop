@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <h1 class="mb-4 text-center">{{ $car->name ?? 'Unnamed Car' }}</h1>

        @if ($car->image)
            <div class="text-center mb-4">
                <img src="{{ asset('storage/' . $car->image) }}" alt="{{ $car->name }}" class="img-fluid rounded shadow"
                    style="max-height: 450px;">
            </div>
        @endif
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

        <form id="likeForm" action="{{ route('like.toggle') }}" method="POST" class="mt-4">
            @csrf
            <input type="hidden" name="car_id" value="{{ $car->id }}">
            <input type="hidden" name="like" value="1">
            <button type="submit" id="likeButton" class="like-btn {{ $liked ? 'liked' : '' }}"
                aria-pressed="{{ $liked ? 'true' : 'false' }}" aria-label="Toggle Like">

                <svg xmlns="http://www.w3.org/2000/svg" class="icon thumbs-up-icon"
                    fill="{{ $liked ? '#3b82f6' : '#9ca3af' }}" viewBox="0 0 24 24" stroke="none">
                    <path
                        d="M2 20h2v-9H2v9zm19-11h-6.31l.95-4.57.03-.32a.996.996 0 0 0-.29-.7L14.17 2 7.59 8.59C7.22 8.95 7 9.45 7 10v9c0 1.1.9 2 2 2h7c.83 0 1.54-.5 1.84-1.22l3.02-7.05c.09-.23.14-.47.14-.73v-1c0-1.1-.9-2-2-2z" />
                </svg>

                <span id="likesCount" class="likes-count">{{ $likesCount }}</span>
            </button>
        </form>


        {{-- Media Sections --}}
        <div class="row mb-4 g-3">
            <h5>Gallery</h5>
            @php
                $gallery = json_decode($car->gallery_images, true);
            @endphp

            @if (!empty($gallery) && is_array($gallery))
                <div style="overflow-x: auto; white-space: nowrap; padding-bottom: 10px;">
                    @foreach ($gallery as $index => $image)
                        <img src="{{ asset('storage/' . $image) }}" alt="Gallery Image"
                            style="height: 150px; width: auto; display: inline-block; margin-right: 10px; border-radius: 5px; box-shadow: 0 2px 6px rgba(0,0,0,0.2); cursor: pointer;"
                            onclick="openFullscreen('{{ asset('storage/' . $image) }}')" />
                    @endforeach
                </div>
            @else
                <p>No gallery images available.</p>
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

            // Close modal when clicking outside the image
            document.getElementById('fullscreenModal').addEventListener('click', function(e) {
                if (e.target === this) {
                    closeFullscreen();
                }
            });
        </script>



        @if ($car->documents)
            <div class="col-12">
                <h5 class="text-muted">Documents</h5>
                <ul class="list-unstyled">
                    @foreach ($car->documents as $document)
                        <li><a href="{{ asset('storage/' . $document) }}" target="_blank">{{ basename($document) }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if ($car->video)
            <div class="col-12">
                <h5 class="text-muted">Video</h5>
                <video controls class="w-100 rounded shadow-sm" style="max-height: 400px;">
                    <source src="{{ asset('storage/' . $car->video) }}" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            </div>
        @endif
    </div>

    {{-- Car Info --}}
    <div class="row row-cols-1 row-cols-md-2 g-4">
        <div class="col">
            <div class="p-3 border rounded shadow-sm bg-light">
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
        </div>
        <div class="col">
            <div class="p-3 border rounded shadow-sm bg-light">
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
    {{-- Reserve Button (if not car owner) --}}
    @if (Auth::check() && $car->created_by_id != Auth::id())
        <a href="{{ route('reservations.create', ['car' => $car->id]) }}" class="fixed-button btn btn-primary">
            Reserve Now
        </a>
    @endif
    <style>
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

    {{-- Features --}}


    </div>
@endsection
