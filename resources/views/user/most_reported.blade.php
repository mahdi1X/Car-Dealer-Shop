@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <h2 class="mb-4">Most Reported Users</h2>
        <div class="table-responsive">
            <table class="table table-hover table-modern align-middle shadow-sm rounded-4">
                <thead class="table-primary">
                    <tr>
                        <th>User Name</th>
                        <th>Email</th>
                        <th>Region</th>
                        <th>Number of Reports</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($mostReported as $item)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <span class="avatar bg-primary text-white rounded-circle me-2"
                                        style="width:32px;height:32px;display:flex;align-items:center;justify-content:center;">
                                        {{ strtoupper(substr($item['user']->name, 0, 1)) }}
                                    </span>
                                    <span>{{ $item['user']->name }}</span>
                                </div>
                            </td>
                            <td>{{ $item['user']->email }}</td>
                            <td>{{ $item['user']->region ?? '-' }}</td>
                            <td>
                                <span class="badge bg-danger">{{ $item['reports_count'] }}</span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4">No reported users found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <a href="{{ route('users.index') }}" class="btn btn-secondary mt-3">Back to Users Management</a>
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
