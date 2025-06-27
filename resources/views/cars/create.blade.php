@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <h1>{{ isset($car->id) ? 'Update Car' : 'Create a New Car' }}</h1>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form action="{{ isset($car->id) ? route('cars.update', $car->id) : route('cars.store') }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            @if (isset($car->id))
                @method('PUT')
            @endif

            {{-- BASIC INFO TABLE --}}
            <table class="table mb-4" style="border: 2px solid #ffffff; border-radius: 5px;">
                <thead>
                    <tr>
                        <th colspan="2" class="bg-primary text-white">Basic Info</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="width: 30%; vertical-align: middle;"> <label for="name"
                                class="form-label">Name</label> </td>
                        <td>
                            <input type="text" name="name" id="name" class="form-control"
                                value="{{ old('name', $car->name ?? '') }}" required>
                            @error('name')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </td>
                    </tr>
                    <tr>
                        <td> <label for="color" class="form-label">Color</label> </td>
                        <td>
                            <input type="text" name="color" id="color" class="form-control"
                                value="{{ old('color', $car->color ?? '') }}" required>
                            @error('color')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </td>
                    </tr>
                    <tr>
                        <td> <label for="brand_id" class="form-label">Brand</label> </td>
                        <td>
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
                        </td>
                    </tr>
                    <tr>
                        <td> <label for="year" class="form-label">Year</label> </td>
                        <td>
                            <input type="number" name="year" id="year" class="form-control"
                                value="{{ old('year', $car->year ?? '') }}" required>
                            @error('year')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </td>
                    </tr>
                    <tr>
                        <td> <label for="price" class="form-label">Price</label> </td>
                        <td>
                            <input type="number" step="0.01" name="price" id="price" class="form-control"
                                value="{{ old('price', $car->price ?? '') }}" required>
                            @error('price')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </td>
                    </tr>
                    <tr>
                        <td> <label for="km_recorded" class="form-label">KM Recorded</label> </td>
                        <td>
                            <input type="number" step="0.01" name="km_recorded" id="km_recorded" class="form-control"
                                value="{{ old('km_recorded', $car->km_recorded ?? '') }}" required>
                            @error('km_recorded')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </td>
                    </tr>
                    <tr>
                        <td> <label for="length" class="form-label">Length (m)</label> </td>
                        <td>
                            <input type="number" step="0.01" name="length" id="length" class="form-control"
                                value="{{ old('length', $car->length ?? '') }}" required>
                            @error('length')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </td>
                    </tr>
                    <tr>
                        <td> <label for="image" class="form-label">Car Image</label> </td>
                        <td>
                            <input type="file" name="image" id="image" class="form-control">
                            @if (!empty($car->image))
                                <small class="form-text text-muted">Current: {{ $car->image }}</small>
                            @endif
                            @error('image')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </td>
                    </tr>
                    
                </tbody>
            </table>

            {{-- PERFORMANCE SPECS TABLE --}}
            <table class="table mb-4" style="border: 2px solid #ffffff; border-radius: 5px;">
                <thead>
                    <tr>
                        <th colspan="2" class="bg-primary text-white">Performance Specs</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><label for="transmission" class="form-label">Transmission</label></td>
                        <td>
                            <input type="text" name="transmission" id="transmission" class="form-control"
                                value="{{ old('transmission', $car->transmission ?? '') }}">
                            @error('transmission')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </td>
                    </tr>
                    <tr>
                        <td><label for="engine_type" class="form-label">Engine Type</label></td>
                        <td>
                            <input type="text" name="engine_type" id="engine_type" class="form-control"
                                value="{{ old('engine_type', $car->engine_type ?? '') }}">
                            @error('engine_type')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </td>
                    </tr>
                    <tr>
                        <td><label for="engine_size" class="form-label">Engine Size</label></td>
                        <td>
                            <input type="text" name="engine_size" id="engine_size" class="form-control"
                                value="{{ old('engine_size', $car->engine_size ?? '') }}">
                            @error('engine_size')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </td>
                    </tr>
                    <tr>
                        <td><label for="horsepower" class="form-label">Horsepower</label></td>
                        <td>
                            <input type="number" name="horsepower" id="horsepower" class="form-control"
                                value="{{ old('horsepower', $car->horsepower ?? '') }}">
                            @error('horsepower')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </td>
                    </tr>
                    <tr>
                        <td><label for="torque" class="form-label">Torque</label></td>
                        <td>
                            <input type="number" name="torque" id="torque" class="form-control"
                                value="{{ old('torque', $car->torque ?? '') }}">
                            @error('torque')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </td>
                    </tr>
                    <tr>
                        <td><label for="drivetrain" class="form-label">Drivetrain</label></td>
                        <td>
                            <input type="text" name="drivetrain" id="drivetrain" class="form-control"
                                value="{{ old('drivetrain', $car->drivetrain ?? '') }}">
                            @error('drivetrain')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </td>
                    </tr>
                    <tr>
                        <td><label for="fuel_type" class="form-label">Fuel Type</label></td>
                        <td>
                            <input type="text" name="fuel_type" id="fuel_type" class="form-control"
                                value="{{ old('fuel_type', $car->fuel_type ?? '') }}">
                            @error('fuel_type')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </td>
                    </tr>
                    <tr>
                        <td><label for="fuel_economy" class="form-label">Fuel Economy</label></td>
                        <td>
                            <input type="text" name="fuel_economy" id="fuel_economy" class="form-control"
                                value="{{ old('fuel_economy', $car->fuel_economy ?? '') }}">
                            @error('fuel_economy')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </td>
                    </tr>
                </tbody>
            </table>

            {{-- FEATURES & OPTIONS TABLE --}}
            <table class="table mb-4" style="border: 2px solid #ffffff; border-radius: 5px;">
                <thead>
                    <tr>
                        <th colspan="2" class="bg-primary text-white">Features & Options</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><label for="body_type" class="form-label">Body Type</label></td>
                        <td>
                            <input type="text" name="body_type" id="body_type" class="form-control"
                                value="{{ old('body_type', $car->body_type ?? '') }}">
                            @error('body_type')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </td>
                    </tr>
                    <tr>
                        <td><label for="seats" class="form-label">Seats</label></td>
                        <td>
                            <input type="number" name="seats" id="seats" class="form-control"
                                value="{{ old('seats', $car->seats ?? '') }}">
                            @error('seats')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </td>
                    </tr>
                    <tr>
                        <td><label for="doors" class="form-label">Doors</label></td>
                        <td>
                            <input type="number" name="doors" id="doors" class="form-control"
                                value="{{ old('doors', $car->doors ?? '') }}">
                            @error('doors')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </td>
                    </tr>
                    <tr>
                        <td><label for="interior_color" class="form-label">Interior Color</label></td>
                        <td>
                            <input type="text" name="interior_color" id="interior_color" class="form-control"
                                value="{{ old('interior_color', $car->interior_color ?? '') }}">
                            @error('interior_color')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </td>
                    </tr>
                    @php
                        // Predefined features list
                        $allFeatures = [
                            'Sunroof',
                            'Bluetooth',
                            'Backup Camera',
                            'Navigation System',
                            'Leather Seats',
                            'Cruise Control',
                            'Heated Seats',
                            'Remote Start',
                            'Blind Spot Monitor',
                            'Parking Sensors',
                        ];

                        // Features saved in DB (JSON decoded)
                        $savedFeatures = old(
                            'features',
                            isset($car->features) ? json_decode($car->features, true) : [],
                        );
                        if (!is_array($savedFeatures)) {
                            $savedFeatures = [];
                        }

                        // Features that are already predefined and selected
                        $predefinedSelected = array_intersect($savedFeatures, $allFeatures);

                        // Features that are "new" (not in predefined list)
                        $newFeatures = array_diff($savedFeatures, $allFeatures);

                        // Join new features into comma-separated string for text input
                        $newFeaturesString = old('new_features', implode(', ', $newFeatures));
                    @endphp

                    <tr>
                        <td><label class="form-label">Features</label></td>
                        <td>
                            {{-- Show checkboxes for predefined features --}}
                            @foreach ($allFeatures as $feature)
                                <div class="form-check">
                                    <input type="checkbox" name="features[]" value="{{ $feature }}"
                                        id="feature_{{ Str::slug($feature) }}" class="form-check-input"
                                        {{ in_array($feature, $predefinedSelected) ? 'checked' : '' }}>
                                    <label for="feature_{{ Str::slug($feature) }}"
                                        class="form-check-label">{{ $feature }}</label>
                                </div>
                            @endforeach

                            {{-- Input for adding new features --}}
                            <div class="mt-2">
                                <label for="new_features" class="form-label">Add New Features (comma separated)</label>
                                <input type="text" name="new_features" id="new_features" class="form-control"
                                    placeholder="e.g. Fog Lights, Wireless Charging" value="{{ $newFeaturesString }}">
                            </div>

                            @error('features')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                            @error('new_features')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </td>
                    </tr>

                    <tr>
                        <td><label for="safety_rating" class="form-label">Safety Rating</label></td>
                        <td>
                            <input type="text" name="safety_rating" id="safety_rating" class="form-control"
                                value="{{ old('safety_rating', $car->safety_rating ?? '') }}">
                            @error('safety_rating')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </td>
                    </tr>
                </tbody>
            </table>

            {{-- DOCUMENTS & MEDIA TABLE --}}
            <table class="table mb-4" style="border: 2px solid #ffffff; border-radius: 5px;">
                <thead>
                    <tr>
                        <th colspan="2" class="bg-primary text-white">Documents & Media</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><label for="documents" class="form-label">Upload Documents (multiple)</label></td>
                        <td>
                            <input type="file" name="documents[]" id="documents" class="form-control" multiple>
                            @if (!empty($car->documents))
                                <small class="form-text text-muted">Current:
                                    {{ is_array($car->documents) ? implode(', ', $car->documents) : $car->documents }}</small>
                            @endif
                            @error('documents')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </td>
                    </tr>
                    <tr>
                        <td><label for="gallery_images" class="form-label">Upload Gallery Images (multiple)</label></td>
                        <td>
                            <input type="file" name="gallery_images[]" id="gallery_images" class="form-control" multiple>

                            @if (!empty($car->gallery_images))
                                <small class="form-text text-muted">Current:
                                    {{ is_array($car->gallery_images) ? implode(', ', $car->gallery_images) : $car->gallery_images }}</small>
                            @endif
                            @error('gallery_images')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror

                        </td>
                    </tr>
                    <tr>
                        <td><label for="video" class="form-label">Video</label></td>
                        <td>
                            <input type="file" name="video" id="video" class="form-control">
                            @if (!empty($car->video))
                                <small class="form-text text-muted">Current: {{ $car->video }}</small>
                            @endif
                            @error('video')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </td>
                    </tr>
                </tbody>
            </table>

            {{-- LOCATION TABLE --}}
            <table class="table mb-4" style="border: 2px solid #ffffff; border-radius: 5px;">
                <thead>
                    <tr>
                        <th colspan="2" class="bg-primary text-white">Location</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><label for="location" class="form-label">Location</label></td>
                        <td>
                            <input type="text" name="location" id="location" class="form-control"
                                value="{{ old('location', $car->location ?? '') }}">
                            @error('location')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </td>
                    </tr>
                </tbody>
            </table>

            {{-- HISTORY & CONDITION TABLE --}}
            <table class="table mb-4" style="border: 2px solid #ffffff; border-radius: 5px;">
                <thead>
                    <tr>
                        <th colspan="2" class="bg-primary text-white">History & Condition</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><label for="condition" class="form-label">Condition</label></td>
                        <td>
                            <input type="text" name="condition" id="condition" class="form-control"
                                value="{{ old('condition', $car->condition ?? '') }}">
                            @error('condition')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </td>
                    </tr>
                    <tr>
                        <td><label for="service_history" class="form-label">Service History</label></td>
                        <td>
                            <input type="text" name="service_history" id="service_history" class="form-control"
                                value="{{ old('service_history', $car->service_history ?? '') }}">
                            @error('service_history')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </td>
                    </tr>
                    <tr>
                        <td><label for="accident_history" class="form-label">Accident History</label></td>
                        <td>
                            <input type="text" name="accident_history" id="accident_history" class="form-control"
                                value="{{ old('accident_history', $car->accident_history ?? '') }}">
                            @error('accident_history')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </td>
                    </tr>
                    <tr>
                        <td><label for="ownership_count" class="form-label">Ownership Count</label></td>
                        <td>
                            <input type="number" name="ownership_count" id="ownership_count" class="form-control"
                                value="{{ old('ownership_count', $car->ownership_count ?? '') }}">
                            @error('ownership_count')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </td>
                    </tr>
                    <tr>
                        <td><label for="registration_valid_till" class="form-label">Registration Valid Till</label></td>
                        <td>
                            <input type="date" name="registration_valid_till" id="registration_valid_till" class="form-control"
                                value="{{ old('registration_valid_till', $car->registration_valid_till ?? '') }}">
                            @error('registration_valid_till')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </td>
                    </tr>
                </tbody>
            </table>

            {{-- LOCATION & LOGISTICS TABLE --}}
            

            <button type="submit" class="btn btn-primary">
                {{ isset($car->id) ? 'Update' : 'Create' }}
            </button>
        </form>
    </div>
@endsection
