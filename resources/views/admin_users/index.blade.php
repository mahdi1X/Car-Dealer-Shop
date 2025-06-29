@extends('layouts.app')

@section('content')

    <div class="container mt-4">
        <br>
        <h1 class="mb-4 text-center">Mangers Management</h1>

        {{-- Only Admins can create new users --}}
        @if (Auth::user()->role === 'admin')
            <a href="{{ route('admin_users.create') }}" class="btn btn-primary mb-3">Add New Managr</a>
        @endif

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="table-responsive">
            <table class="table table-hover table-modern align-middle shadow-sm rounded-4">
                <thead class="table-primary">
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
                                <div class="d-flex align-items-center">
                                    <span class="avatar bg-primary text-white rounded-circle me-2"
                                        style="width:32px;height:32px;display:flex;align-items:center;justify-content:center;">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </span>
                                    <span>
                                        {{ $user->name }}
                                        @if (Auth::id() == $user->id)
                                            (You)
                                        @endif
                                    </span>
                                </div>
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
        <style>
            .table-modern {
                border-radius: 16px;
                overflow: hidden;
                background: #fff;
                box-shadow: 0 4px 24px rgba(75,139,145,0.08), 0 2px 8px rgba(0,0,0,0.04);
            }
            .table-modern thead th {
                background: linear-gradient(90deg, #4b8b91 60%, #2196F3 100%);
                color: #fff;
                font-weight: 600;
                border: none;
                font-size: 1.08rem;
                letter-spacing: 0.5px;
            }
            .table-modern tbody tr {
                transition: background 0.2s;
            }
            .table-modern tbody tr:hover {
                background: #e0f7fa;
            }
            .table-modern td, .table-modern th {
                border: none;
                vertical-align: middle;
            }
            .avatar {
                font-size: 1.1rem;
                font-weight: 700;
                width: 32px;
                height: 32px;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                border-radius: 50%;
                background: #4b8b91;
            }
            .badge {
                font-size: 0.95rem;
                font-weight: 500;
            }
        </style>
    </div>
@endsection
