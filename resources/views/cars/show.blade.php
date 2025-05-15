@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Car Details</h1>

    <div class="card">
        <div class="card-header">
            <h2>{{ $car->name }}</h2>
        </div>
        <div class="card-body">
            <p><strong>Owner:</strong>{{$car->createdBy->name}}</p>
            <p><strong>Color:</strong> {{ $car->color }}</p>
            <p><strong>Brand:</strong> {{ $car->brand->name }}</p>
            <p><strong>Year:</strong> {{ $car->year }}</p>
            <p><strong>Price:</strong> ${{ number_format($car->price, 2) }}</p>
            <p><strong>KM Recorded:</strong> {{ $car->km_recorded }}</p>
            <p><strong>Length:</strong> {{ $car->length }} meters</p>
            <div class="flex items-center justify-center space-x-2 mt-4">
   @php
    $liked = auth()->check() && $car->likes()->where('user_id', auth()->id())->where('like', 1)->exists();
    $likesCount = $car->likes()->count();
@endphp

<form id="likeForm" action="{{ route('like.toggle') }}" method="POST" class="inline">
    @csrf
    <input type="hidden" name="car_id" value="{{ $car->id }}">
    <input type="hidden" name="like" value="1">
    <button type="submit"
        id="likeButton"
        class="like-btn {{ $liked ? 'liked' : '' }}"
        aria-pressed="{{ $liked ? 'true' : 'false' }}"
        aria-label="Toggle Like">

        <!-- Thumbs up icon only -->
        <svg xmlns="http://www.w3.org/2000/svg" class="icon thumbs-up-icon" fill="{{ $liked ? '#3b82f6' : '#9ca3af' }}" viewBox="0 0 24 24" stroke="none" >
            <path d="M2 20h2v-9H2v9zm19-11h-6.31l.95-4.57.03-.32a.996.996 0 0 0-.29-.7L14.17 2 7.59 8.59C7.22 8.95 7 9.45 7 10v9c0 1.1.9 2 2 2h7c.83 0 1.54-.5 1.84-1.22l3.02-7.05c.09-.23.14-.47.14-.73v-1c0-1.1-.9-2-2-2z"/>
        </svg>

        <span id="likesCount" class="likes-count">{{ $likesCount }}</span>
    </button>
</form>

<style>
    .like-btn {
        display: inline-flex;
        align-items: center;
        gap: 12px;
        font-weight: 600;
        font-size: 1.5rem; /* bigger font size */
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
        display: block;
        width: 48px;  /* BIGGER icon size */
        height: 48px;
        flex-shrink: 0;
        transition: fill 0.3s ease;
    }

    .likes-count {
        min-width: 32px;
        text-align: left;
        color: inherit;
        transition: color 0.3s ease;
    }
</style>

<script>
    document.getElementById('likeForm').addEventListener('submit', function(e) {
        e.preventDefault();

        let form = this;
        let url = form.action;
        let formData = new FormData(form);

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
            let likeBtn = document.getElementById('likeButton');
            let likesCount = document.getElementById('likesCount');
            let icon = likeBtn.querySelector('.thumbs-up-icon');

            if(data.liked) {
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
        .catch(err => console.error('Error:', err));
    });
</script>


            
            @if ($car->image)
                <div>
                    <img src="{{ asset('storage/' . $car->image) }}" alt="{{ $car->name }}" style="max-width: 100%; height: auto;">
                </div>
            @else
                <p><strong>Image:</strong> No image available</p>
            @endif
        </div>
    </div>
</div>

<!-- Fixed Button -->
@if(Auth::check() && $car->created_by_id != Auth::id())
    <a href="{{ route('reservations.create', ['car' => $car->id]) }}" class="fixed-button btn btn-primary">
        Reserve Now
    </a>
@endif

@endsection

<!-- Add inline or separate CSS -->
<style>
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
