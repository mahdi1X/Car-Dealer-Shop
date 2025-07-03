@extends('layouts.app')

@section('content')
    @if (auth()->user()->role === 'manager')
    <br>
        <h2 class="mb-4">Reports</h2>
        <br>
        <div class="table-responsive">
            <table class="table table-hover table-modern align-middle shadow-sm rounded-4">
                <thead class="table-primary">
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
                            <td>
                                <div class="d-flex align-items-center">
                                    <span class="avatar bg-primary text-white rounded-circle me-2"
                                        style="width:32px;height:32px;display:flex;align-items:center;justify-content:center;">
                                        {{ strtoupper(substr($report->reportedUser->name, 0, 1)) }}
                                    </span>
                                    <span>{{ $report->reportedUser->name }}</span>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <span class="avatar bg-secondary text-white rounded-circle me-2"
                                        style="width:32px;height:32px;display:flex;align-items:center;justify-content:center;">
                                        {{ strtoupper(substr($report->reporterUser->name, 0, 1)) }}
                                    </span>
                                    <span>{{ $report->reporterUser->name }}</span>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-light text-dark px-3 py-2 rounded-pill">{{ $report->reason }}</span>
                            </td>
                            <td>
                                @if ($report->to_admin)
                                    <span class="badge bg-success">Yes</span>
                                @else
                                    <span class="badge bg-warning text-dark">No</span>
                                    <button class="btn btn-sm btn-outline-warning ms-2"
                                        onclick="toggleForm({{ $report->id }})">
                                        Submit to Admin
                                    </button>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('reports.show', $report->id) }}" class="btn btn-outline-primary btn-sm">View
                                </a>
                                <form action="{{ route('reports.destroy', $report->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Are you sure you want to delete this report?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger btn-sm ms-1">Delete</button>
                                </form>
                            </td>
                        </tr>
                        <tr id="form-row-{{ $report->id }}" style="display: none;">
                            <td colspan="5" class="bg-light">
                                <form action="{{ route('admin-reports.store', $report->id) }}" method="POST"
                                    class="d-flex align-items-center gap-2">
                                    @csrf
                                    <textarea name="note" class="form-control me-2" placeholder="Explain to admin..."
                                        required style="max-width:350px;"></textarea>
                                    <button type="submit" class="btn btn-success btn-sm">Confirm Submit</button>
                                    <button type="button" class="btn btn-secondary btn-sm"
                                        onclick="toggleForm({{ $report->id }})">Cancel</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{-- Modern Table Styles --}}
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
        {{-- JS to toggle the form --}}
        <script>
            function toggleForm(id) {
                const row = document.getElementById('form-row-' + id);
                row.style.display = row.style.display === 'none' ? 'table-row' : 'none';
            }
        </script>
    @endif
@endsection
