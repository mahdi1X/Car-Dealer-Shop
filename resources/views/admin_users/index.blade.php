@extends('layouts.app')

@section('content')

    <div class="container mt-4">
        <br>
        <h1 class="mb-4 text-center">User Management (Admins & Managers)</h1>

        {{-- Only Admins can create new users --}}
        @if (Auth::user()->role === 'admin')
            <a href="{{ route('admin_users.create') }}" class="btn btn-primary mb-3">Create New User</a>
        @endif

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Region</th>
                    @if (Auth::user()->role === 'admin')
                        <th>Actions</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                    <tr>
                        <td>
                            {{ $user->name }}
                            @if (Auth::id() == $user->id)
                                (You)
                            @endif
                        </td>
                        <td>{{ $user->email }}</td>
                        <td>{{ ucfirst($user->role) }}</td>
                        <td>{{ $user->region ?? '—' }}</td>
                        @if (Auth::user()->role === 'admin')
                            <td>
                                @if (Auth::id() !== $user->id)
                                    <a href="{{ route('admin_users.edit', $user->id) }}"
                                        class="btn btn-sm btn-warning">Edit</a>

                                    <form action="{{ route('admin_users.destroy', $user->id) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger"
                                            onclick="return confirm('Delete this user?')">Delete</button>
                                    </form>
                                @else
                                    <span class="text-muted">N/A</span>
                                @endif
                            </td>
                        @endif
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">No users found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
