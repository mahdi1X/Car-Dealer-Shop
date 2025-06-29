@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <h2 class="mb-4">Users Management</h2>

        <!-- Search Bar -->
        <form method="GET" action="{{ route('users.index') }}" class="mb-4">
            <div class="input-group" style="max-width: 400px;">
                <input type="text" name="search" class="form-control" placeholder="Search by name"
                    value="{{ $search ?? '' }}">
                <button class="btn btn-outline-secondary" type="submit">Search</button>
            </div>
        </form>

        <!-- Most Reported Users Button -->
        <div class="mb-3">
            <a href="{{ route('users.most_reported') }}" class="btn btn-danger">
                Most Reported Users
            </a>
        </div>

        <!-- Toggle Buttons -->
        <div class="mb-3">
            <button class="btn btn-primary" onclick="showTable('all-users')">All Users</button>
            <button class="btn btn-warning" onclick="showTable('banned-users')">Banned Users</button>
        </div>

        <!-- All Users Table -->
        <div id="all-users">
            <div class="table-responsive">
                <table class="table table-hover table-modern align-middle shadow-sm rounded-4">
                    <thead class="table-primary">
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Ban Status / Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            @if (!$user->isCurrentlyBanned())
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <span class="avatar bg-primary text-white rounded-circle me-2"
                                                style="width:32px;height:32px;display:flex;align-items:center;justify-content:center;">
                                                {{ strtoupper(substr($user->name, 0, 1)) }}
                                            </span>
                                            <span>{{ $user->name }}</span>
                                        </div>
                                    </td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-danger" onclick="toggleBanForm({{ $user->id }})">
                                            Ban
                                        </button>
                                        <!-- Hidden Ban Form -->
                                        <div id="ban-form-{{ $user->id }}" class="mt-2" style="display: none;">
                                            <form method="POST" action="{{ route('users.ban', $user->id) }}">
                                                @csrf
                                                <div class="form-group mb-2">
                                                    <label>Reason</label>
                                                    <input type="text" name="reason" class="form-control" required>
                                                </div>
                                                <div class="form-group mb-2">
                                                    <label>Ban Type</label><br>
                                                    <input type="radio" name="type" value="temporary"
                                                        onchange="toggleDuration({{ $user->id }}, true)" required> Temporary
                                                    <input type="radio" name="type" value="permanent"
                                                        onchange="toggleDuration({{ $user->id }}, false)"> Permanent
                                                </div>
                                                <div class="form-group mb-2" id="duration-group-{{ $user->id }}"
                                                    style="display: none;">
                                                    <label>Duration (Days)</label>
                                                    <input type="number" name="duration" class="form-control" min="1">
                                                </div>
                                                <button type="submit" class="btn btn-danger btn-sm">Confirm Ban</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <!-- Banned Users Table -->
        <div id="banned-users" style="display: none;">
            <div class="table-responsive">
                <table class="table table-hover table-modern align-middle shadow-sm rounded-4">
                    <thead class="table-primary">
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Ban Reason</th>
                            <th>Banned Until</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            @if ($user->isCurrentlyBanned())
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <span class="avatar bg-secondary text-white rounded-circle me-2"
                                                style="width:32px;height:32px;display:flex;align-items:center;justify-content:center;">
                                                {{ strtoupper(substr($user->name, 0, 1)) }}
                                            </span>
                                            <span>{{ $user->name }}</span>
                                        </div>
                                    </td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->ban_reason }}</td>
                                    <td>
                                        {{ $user->banned_until ? $user->banned_until->format('Y-m-d') : 'Permanent' }}
                                    </td>
                                    <td>
                                        <form method="POST" action="{{ route('users.unban', $user->id) }}">
                                            @csrf
                                            <button class="btn btn-sm btn-success">Unban</button>
                                        </form>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
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

            .table-modern td,
            .table-modern th {
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

    <!-- Scripts -->
    <script>
        function toggleBanForm(userId) {
            let form = document.getElementById('ban-form-' + userId);
            form.style.display = form.style.display === 'none' ? 'block' : 'none';
        }

        function toggleDuration(userId, show) {
            let group = document.getElementById('duration-group-' + userId);
            group.style.display = show ? 'block' : 'none';
        }

        function showTable(tableId) {
            document.getElementById('all-users').style.display = 'none';
            document.getElementById('banned-users').style.display = 'none';

            document.getElementById(tableId).style.display = 'block';
        }
    </script>
@endsection
