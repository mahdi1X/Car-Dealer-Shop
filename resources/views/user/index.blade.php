@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <h2 class="mb-4">Search Results</h2>

        @if ($users->count())
            <ul class="list-group">
                @foreach ($users as $user)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        {{ $user->name }}
                        <a href="{{ route('user.profile', $user->id) }}" class="btn btn-sm btn-primary">View Profile</a>
                    </li>
                @endforeach
            </ul>

            <div class="mt-4">
                {{ $users->appends(['search' => $search])->links() }}
            </div>
        @else
            <p>No users found.</p>
        @endif
    </div>
@endsection
