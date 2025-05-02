@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <h1 class="mb-4">Admin Users</h1>
        <a href="{{ route('admin_users.create') }}" class="btn btn-primary mb-3">Create New Admin</a>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Address</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($admins as $admin)
                    <tr>
                        <td>{{ $admin->name }}
                            @if (Auth::user()->id == $admin->id)
                                (You)
                            @endif

                        </td>
                        <td>{{ $admin->email }}</td>
                        <td>{{ $admin->address }}</td>
                        <td>
                            @if (Auth::user()->id != $admin->id)
                                <a href="{{ route('admin_users.edit', $admin->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('admin_users.destroy', $admin->id) }}" method="POST"
                                    class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger"
                                        onclick="return confirm('Delete this admin?')">Delete</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">No admins found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
