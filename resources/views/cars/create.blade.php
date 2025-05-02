    @extends('layouts.app')

    @section('content')
        <div class="container mt-5">
            <h1>Create a New Car</h1>

            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ isset($car->id) ? route('cars.update', $car->id) : route('cars.store') }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                @if (isset($car->id))
                    @method('PUT')
                @endif

                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" name="name" id="name" class="form-control"
                        value="{{ old('name', $car->name ?? '') }}" required>
                    @error('name')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="color" class="form-label">Color</label>
                    <input type="text" name="color" id="color" class="form-control"
                        value="{{ old('color', $car->color ?? '') }}" required>
                    @error('color')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="brand_id" class="form-label">Brand</label>
                    <select name="brand_id" id="brand_id" class="form-control" required>
                        @foreach ($brands as $brand)
                            <option value="{{ $brand->id }}"
                                {{ old('brand_id', $car->brand_id ?? '') == $brand->id ? 'selected' : '' }}>
                                {{ $brand->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('brand_id')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="year" class="form-label">Year</label>
                    <input type="number" name="year" id="year" class="form-control"
                        value="{{ old('year', $car->year ?? '') }}" required>
                    @error('year')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="price" class="form-label">Price</label>
                    <input type="number" step="0.01" name="price" id="price" class="form-control"
                        value="{{ old('price', $car->price ?? '') }}" required>
                    @error('price')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="length" class="form-label">KM Recorded</label>
                    <input type="number" step="0.01" name="km_recorded" id="km_recorded" class="form-control"
                        value="{{ old('length', $car->km_recorded ?? '') }}" required>
                    @error('length')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="length" class="form-label">Length (in meters)</label>
                    <input type="number" step="0.01" name="length" id="length" class="form-control"
                        value="{{ old('length', $car->length ?? '') }}" required>
                    @error('length')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="image" class="form-label">Car Image</label>
                    <input type="file" name="image" id="image" class="form-control">
                    @if (!empty($car->image))
                        <small class="form-text text-muted">Current image: {{ $car->image }}</small>
                    @endif
                    @error('image')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">
                    {{ isset($car->id) ? 'Update Car' : 'Create Car' }}
                </button>
            </form>

        </div>
    @endsection
