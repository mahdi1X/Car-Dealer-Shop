@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Car Details</h1>

        <div class="card">
            <div class="card-header">
                <h2>{{ $car->name }}</h2>
            </div>
            <div class="card-body">
                <p><i class="bi bi-person-fill me-1 text-dark"></i> <strong>Owner:</strong> {{ $car->createdBy->name }}</p>
                <p><i class="bi bi-palette-fill me-1 text-dark"></i> <strong>Color:</strong> {{ $car->color }}</p>
                <p><i class="bi bi-shield-check me-1 text-dark"></i> <strong>Brand:</strong> {{ $car->brand->name }}</p>
                <p><i class="bi bi-calendar3 me-1 text-dark"></i> <strong>Year:</strong> {{ $car->year }}</p>
                <p><i class="bi bi-cash-stack me-1 text-dark"></i> <strong>Price:</strong>
                    ${{ number_format($car->price, 2) }}</p>
                <p><i class="bi bi-speedometer2 me-1 text-dark"></i> <strong>KM Recorded:</strong> {{ $car->km_recorded }}
                </p>
                <p><i class="bi bi-arrows-angle-expand me-1 text-dark"></i> <strong>Length:</strong> {{ $car->length }}
                    meters</p>

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

                {{-- Car Image --}}
                @if ($car->image)
                    <div class="mt-4">
                        <img src="{{ asset('storage/' . $car->image) }}" alt="{{ $car->name }}"
                            style="max-width: 100%; height: auto;">
                    </div>
                @else
                    <p><strong>Image:</strong> No image available</p>
                @endif
            </div>
        </div>

        {{-- Reserve Button (if not car owner) --}}
        @if (Auth::check() && $car->created_by_id != Auth::id())
            <a href="{{ route('reservations.create', ['car' => $car->id]) }}" class="fixed-button btn btn-primary">
                Reserve Now
            </a>
        @endif
    </div>
@endsection

{{-- Inline Styles --}}
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

{{-- AJAX Script --}}
<script>
    document.getElementById('likeForm').addEventListener('submit', function(e) {
        e.preventDefault();

        const form = this;
        const url = form.action;
        const formData = new FormData(form);

        fetch(url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                const likeBtn = document.getElementById('likeButton');
                const likesCount = document.getElementById('likesCount');
                const icon = likeBtn.querySelector('.thumbs-up-icon');

                if (data.liked) {
                    likeBtn.classList.add('liked');
                    likeBtn.setAttribute('aria-pressed', 'true');
                    icon.setAttribute('fill', '#3b82f6');
                } else {
                    likeBtn.classList.remove('liked');
                    likeBtn.setAttribute('aria-pressed', 'false');
                    icon.setAttribute('fill', '#9ca3af');
                }

                likesCount.textContent = data.likes_count;
            })
            .catch(err => console.error('Like toggle failed:', err));
    });
</script>
