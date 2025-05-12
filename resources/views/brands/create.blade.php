@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <h1>{{ isset($brand) ? 'Edit Brand' : 'Create a New Brand' }}</h1>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form 
            action="{{ isset($brand) ? route('brands.update', $brand->id) : route('brands.store') }}" 
            method="POST" 
            enctype="multipart/form-data"
        >
            @csrf
            @if (isset($brand))
                @method('PUT')
            @endif

            <div class="mb-3">
                <label for="name" class="form-label">Brand Name</label>
                <input 
                    type="text" 
                    name="name" 
                    id="name" 
                    class="form-control" 
                    value="{{ old('name', $brand->name ?? '') }}" 
                    required
                >
                @error('name')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="icon" class="form-label">Brand Icon {{ isset($brand) ? '(Leave blank to keep current)' : '' }}</label>
                <input type="file" name="icon" id="icon" class="form-control">
                @error('icon')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            @if (isset($brand) && $brand->icon)
                <div class="mb-3">
                    <p>Current Icon:</p>
                    <img src="{{ asset('storage/' . $brand->icon) }}" alt="Brand Icon" width="100">
                </div>
            @endif

            <button type="submit" class="btn btn-primary">
                {{ isset($brand) ? 'Update Brand' : 'Create Brand' }}
            </button>
        </form>
    </div>
@endsection
