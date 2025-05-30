@extends('layouts.app')

@section('content')
    @if (auth()->user()->role === 'manager')
        <h2>Reports</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Reported User</th>
                    <th>Reporter</th>
                    <th>Reason</th>
                    <th>Submitted To Admin</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($reports as $report)
                    <tr>
                        <td>{{ $report->reportedUser->name }}</td>
                        <td>{{ $report->reporterUser->name }}</td>
                        <td>{{ $report->reason }}</td>
                        <td>
                            {{ $report->to_admin ? 'Yes' : 'No' }}
                            @if (!$report->to_admin)
                                <button class="btn btn-sm btn-warning" onclick="toggleForm({{ $report->id }})">Submit to
                                    Admin</button>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('reports.show', $report->id) }}" class="btn btn-sm btn-primary">View</a>
                        </td>
                    </tr>
                    <tr id="form-row-{{ $report->id }}" style="display: none;">
                        <td colspan="5">
                            <form action="{{ route('admin-reports.store', $report->id) }}" method="POST">
                                @csrf
                                <textarea name="note" class="form-control mb-2" placeholder="Explain to admin..." required></textarea>
                                <button type="submit" class="btn btn-success btn-sm">Confirm Submit</button>
                                <button type="button" class="btn btn-secondary btn-sm"
                                    onclick="toggleForm({{ $report->id }})">Cancel</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{-- JS to toggle the form --}}
        <script>
            function toggleForm(id) {
                const row = document.getElementById('form-row-' + id);
                row.style.display = row.style.display === 'none' ? 'table-row' : 'none';
            }
        </script>
    @endif
@endsection
