@extends('layouts.app')

@section('content')
    <div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
        <div class="card shadow-lg p-4 modern-form-card" style="max-width: 600px; width: 100%; border-radius: 18px;">
            <h3 class="text-center text-primary mb-4">Submit a Report</h3>

            {{-- Success message --}}
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Validation errors --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('user-reports.store') }}" method="POST">
                @csrf
                <input type="hidden" name="reported_user_id" value="{{ $reportedUser->id }}">

                <div class="mb-3">
                    <label for="reason" class="form-label">Reason</label>
                    <textarea name="reason" id="reason" rows="4" class="form-control" required
                        placeholder="Explain your concern...">{{ old('reason') }}</textarea>
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-danger">Submit Report</button>
                </div>
            </form>
        </div>
        <style>
            .modern-form-card {
                background: linear-gradient(120deg, #f8fafc 80%, #e0f7fa 100%);
                border-radius: 18px;
                box-shadow: 0 8px 32px rgba(75,139,145,0.10), 0 2px 8px rgba(0,0,0,0.04);
                /* Remove hover animation */
                transition: none;
            }

            .modern-form-card:hover {
                box-shadow: 0 8px 32px rgba(75,139,145,0.10), 0 2px 8px rgba(0,0,0,0.04);
                transform: none;
            }
        </style>
    </div>
@endsection
