@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <h1>Create a New Brand</h1>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('brands.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label for="name" class="form-label">Brand Name</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ old('brand') }}" required>
                @error('name')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="icon" class="form-label">Brand Icon</label>
                <input type="file" name="icon" id="icon" class="form-control">
                @error('icon')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Create Brand</button>
        </form>
    </div>
@endsection
