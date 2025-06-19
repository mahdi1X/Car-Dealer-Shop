@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <h2 class="mb-4">Most Reported Users</h2>
        <table class="table table-bordered">
            <thead>
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
                        <td>{{ $item['user']->name }}</td>
                        <td>{{ $item['user']->email }}</td>
                        <td>{{ $item['user']->region ?? '-' }}</td>
                        <td>{{ $item['reports_count'] }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4">No reported users found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <a href="{{ route('users.index') }}" class="btn btn-secondary mt-3">Back to Users Management</a>
    </div>
@endsection
