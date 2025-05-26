@extends('layouts.app')

@section('content')
    <div class="max-w-xl mx-auto bg-white p-6 rounded shadow mt-8">
        <h2 class="text-2xl font-semibold mb-4">Report User</h2>

        {{-- Success message --}}
        @if (session('success'))
            <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        {{-- Validation errors --}}
        @if ($errors->any())
            <div class="bg-red-100 text-red-700 px-4 py-2 rounded mb-4">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('user-reports.store') }}" method="POST" class="space-y-4">
            @csrf

            {{-- Hidden input for reported user ID --}}
            <input type="hidden" name="reported_user_id" value="{{ $reportedUser->id }}">

            <div>
                <label for="reason" class="block font-medium text-gray-700 mb-1">Reason</label>
                <textarea name="reason" id="reason" rows="4"
                    class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-400"
                    required>{{ old('reason') }}</textarea>
            </div>

            <div>
                <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 transition">
                    Submit Report
                </button>
            </div>
        </form>
    </div>
@endsection
