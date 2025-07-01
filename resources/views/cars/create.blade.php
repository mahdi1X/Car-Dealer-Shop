@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        {{-- Show validation errors --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>There were some problems with your submission:</strong>
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <div class="mt-2 text-danger">
                    <small>Note: File uploads (gallery, documents, video) must be re-selected after a validation error.</small>
                </div>
            </div>
        @endif

        <h1>{{ isset($car->id) ? 'Update Car' : 'Create a New Car' }}</h1>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card shadow-lg border-0 modern-form-card" style="border-radius: 18px; max-width: 1200px; margin: 0 auto;">
            <div class="card-body">
                <form action="{{ isset($car->id) ? route('cars.update', $car->id) : route('cars.store') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @if (isset($car->id))
                        @method('PUT')
                    @endif

                    {{-- BASIC INFO TABLE --}}
                    <table class="table mb-4 table-modern">
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
                    <table class="table mb-4 table-modern">
                        <thead>
                            <tr>
                                <th colspan="2" class="bg-primary text-white">Performance Specs</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><label for="transmission" class="form-label">Transmission</label></td>
                                <td>
                                    <select name="transmission" id="transmission" class="form-control">
                                        <option value="">Select Transmission</option>
                                        <option value="Automatic" {{ old('transmission', $car->transmission ?? '') == 'Automatic' ? 'selected' : '' }}>Automatic</option>
                                        <option value="Manual" {{ old('transmission', $car->transmission ?? '') == 'Manual' ? 'selected' : '' }}>Manual</option>
                                        <option value="CVT" {{ old('transmission', $car->transmission ?? '') == 'CVT' ? 'selected' : '' }}>CVT</option>
                                        <option value="Dual-Clutch" {{ old('transmission', $car->transmission ?? '') == 'Dual-Clutch' ? 'selected' : '' }}>Dual-Clutch</option>
                                        <option value="Tiptronic" {{ old('transmission', $car->transmission ?? '') == 'Tiptronic' ? 'selected' : '' }}>Tiptronic</option>
                                    </select>
                                    @error('transmission')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </td>
                            </tr>
                            <tr>
                                <td><label for="engine_type" class="form-label">Engine Type</label></td>
                                <td>
                                    <select name="engine_type" id="engine_type" class="form-control">
                                        <option value="">Select Engine Type</option>
                                        <option value="Petrol" {{ old('engine_type', $car->engine_type ?? '') == 'Petrol' ? 'selected' : '' }}>Petrol</option>
                                        <option value="Diesel" {{ old('engine_type', $car->engine_type ?? '') == 'Diesel' ? 'selected' : '' }}>Diesel</option>
                                        <option value="Hybrid" {{ old('engine_type', $car->engine_type ?? '') == 'Hybrid' ? 'selected' : '' }}>Hybrid</option>
                                        <option value="Electric" {{ old('engine_type', $car->engine_type ?? '') == 'Electric' ? 'selected' : '' }}>Electric</option>
                                        <option value="LPG" {{ old('engine_type', $car->engine_type ?? '') == 'LPG' ? 'selected' : '' }}>LPG</option>
                                        <option value="CNG" {{ old('engine_type', $car->engine_type ?? '') == 'CNG' ? 'selected' : '' }}>CNG</option>
                                    </select>
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
                                    <select name="drivetrain" id="drivetrain" class="form-control">
                                        <option value="">Select Drivetrain</option>
                                        <option value="FWD" {{ old('drivetrain', $car->drivetrain ?? '') == 'FWD' ? 'selected' : '' }}>FWD (Front Wheel Drive)</option>
                                        <option value="RWD" {{ old('drivetrain', $car->drivetrain ?? '') == 'RWD' ? 'selected' : '' }}>RWD (Rear Wheel Drive)</option>
                                        <option value="AWD" {{ old('drivetrain', $car->drivetrain ?? '') == 'AWD' ? 'selected' : '' }}>AWD (All Wheel Drive)</option>
                                        <option value="4WD" {{ old('drivetrain', $car->drivetrain ?? '') == '4WD' ? 'selected' : '' }}>4WD (Four Wheel Drive)</option>
                                    </select>
                                    @error('drivetrain')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </td>
                            </tr>
                            <tr>
                                <td><label for="fuel_type" class="form-label">Fuel Type</label></td>
                                <td>
                                    <select name="fuel_type" id="fuel_type" class="form-control">
                                        <option value="">Select Fuel Type</option>
                                        <option value="Petrol" {{ old('fuel_type', $car->fuel_type ?? '') == 'Petrol' ? 'selected' : '' }}>Petrol</option>
                                        <option value="Diesel" {{ old('fuel_type', $car->fuel_type ?? '') == 'Diesel' ? 'selected' : '' }}>Diesel</option>
                                        <option value="Hybrid" {{ old('fuel_type', $car->fuel_type ?? '') == 'Hybrid' ? 'selected' : '' }}>Hybrid</option>
                                        <option value="Electric" {{ old('fuel_type', $car->fuel_type ?? '') == 'Electric' ? 'selected' : '' }}>Electric</option>
                                        <option value="LPG" {{ old('fuel_type', $car->fuel_type ?? '') == 'LPG' ? 'selected' : '' }}>LPG</option>
                                        <option value="CNG" {{ old('fuel_type', $car->fuel_type ?? '') == 'CNG' ? 'selected' : '' }}>CNG</option>
                                    </select>
                                    @error('fuel_type')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </td>
                            </tr>
                            <tr>
                                <td><label for="fuel_economy" class="form-label">Fuel Economy</label></td>
                                <td>
                                    <select name="fuel_economy" id="fuel_economy" class="form-control">
                                        <option value="">Select Fuel Economy</option>
                                        <option value="Excellent" {{ old('fuel_economy', $car->fuel_economy ?? '') == 'Excellent' ? 'selected' : '' }}>Excellent</option>
                                        <option value="Good" {{ old('fuel_economy', $car->fuel_economy ?? '') == 'Good' ? 'selected' : '' }}>Good</option>
                                        <option value="Average" {{ old('fuel_economy', $car->fuel_economy ?? '') == 'Average' ? 'selected' : '' }}>Average</option>
                                        <option value="Poor" {{ old('fuel_economy', $car->fuel_economy ?? '') == 'Poor' ? 'selected' : '' }}>Poor</option>
                                    </select>
                                    @error('fuel_economy')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    {{-- FEATURES & OPTIONS TABLE --}}
                    <table class="table mb-4 table-modern">
                        <thead>
                            <tr>
                                <th colspan="2" class="bg-primary text-white">Features & Options</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><label for="body_type" class="form-label">Body Type</label></td>
                                <td>
                                    <select name="body_type" id="body_type" class="form-control">
                                        <option value="">Select Body Type</option>
                                        <option value="Sedan" {{ old('body_type', $car->body_type ?? '') == 'Sedan' ? 'selected' : '' }}>Sedan</option>
                                        <option value="Hatchback" {{ old('body_type', $car->body_type ?? '') == 'Hatchback' ? 'selected' : '' }}>Hatchback</option>
                                        <option value="SUV" {{ old('body_type', $car->body_type ?? '') == 'SUV' ? 'selected' : '' }}>SUV</option>
                                        <option value="Coupe" {{ old('body_type', $car->body_type ?? '') == 'Coupe' ? 'selected' : '' }}>Coupe</option>
                                        <option value="Convertible" {{ old('body_type', $car->body_type ?? '') == 'Convertible' ? 'selected' : '' }}>Convertible</option>
                                        <option value="Wagon" {{ old('body_type', $car->body_type ?? '') == 'Wagon' ? 'selected' : '' }}>Wagon</option>
                                        <option value="Pickup" {{ old('body_type', $car->body_type ?? '') == 'Pickup' ? 'selected' : '' }}>Pickup</option>
                                        <option value="Van" {{ old('body_type', $car->body_type ?? '') == 'Van' ? 'selected' : '' }}>Van</option>
                                        <option value="Minivan" {{ old('body_type', $car->body_type ?? '') == 'Minivan' ? 'selected' : '' }}>Minivan</option>
                                        <option value="Other" {{ old('body_type', $car->body_type ?? '') == 'Other' ? 'selected' : '' }}>Other</option>
                                    </select>
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
                    <table class="table mb-4 table-modern">
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
                                        <div class="mt-2">
                                            <strong>Current Documents:</strong>
                                            <ul class="list-unstyled mb-0">
                                                @foreach (is_array($car->documents) ? $car->documents : [$car->documents] as $doc)
                                                    <li>
                                                        <a href="{{ asset('storage/' . $doc) }}" target="_blank">{{ basename($doc) }}</a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
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
                                        <div class="mt-2">
                                            <strong>Current Gallery Images:</strong>
                                            <div class="d-flex flex-wrap gap-2">
                                                @foreach (is_array($car->gallery_images) ? $car->gallery_images : [$car->gallery_images] as $img)
                                                    <img src="{{ asset('storage/' . $img) }}" alt="Gallery Image"
                                                        style="height: 60px; width: auto; border-radius: 4px; box-shadow: 0 1px 4px rgba(0,0,0,0.12);">
                                                @endforeach
                                            </div>
                                        </div>
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
                                        <div class="mt-2">
                                            <strong>Current Video:</strong>
                                            <div>
                                                <a href="{{ asset('storage/' . $car->video) }}" target="_blank">{{ basename($car->video) }}</a>
                                            </div>
                                        </div>
                                    @endif
                                    @error('video')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    {{-- LOCATION TABLE --}}
                    <table class="table mb-4 table-modern">
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
                    <table class="table mb-4 table-modern">
                        <thead>
                            <tr>
                                <th colspan="2" class="bg-primary text-white">History & Condition</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><label for="condition" class="form-label">Condition</label></td>
                                <td>
                                    <select name="condition" id="condition" class="form-control">
                                        <option value="">Select Condition</option>
                                        <option value="New" {{ old('condition', $car->condition ?? '') == 'New' ? 'selected' : '' }}>New</option>
                                        <option value="Like New" {{ old('condition', $car->condition ?? '') == 'Like New' ? 'selected' : '' }}>Like New</option>
                                        <option value="Excellent" {{ old('condition', $car->condition ?? '') == 'Excellent' ? 'selected' : '' }}>Excellent</option>
                                        <option value="Good" {{ old('condition', $car->condition ?? '') == 'Good' ? 'selected' : '' }}>Good</option>
                                        <option value="Fair" {{ old('condition', $car->condition ?? '') == 'Fair' ? 'selected' : '' }}>Fair</option>
                                        <option value="Needs Repair" {{ old('condition', $car->condition ?? '') == 'Needs Repair' ? 'selected' : '' }}>Needs Repair</option>
                                    </select>
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

                    <button type="submit" class="btn btn-primary">
                        {{ isset($car->id) ? 'Update' : 'Create' }}
                    </button>
                </form>
            </div>
        </div>
        <style>
            .modern-form-card {
                background: linear-gradient(120deg, #f8fafc 80%, #e0f7fa 100%);
                border-radius: 18px;
                box-shadow: 0 8px 32px rgba(75,139,145,0.10), 0 2px 8px rgba(0,0,0,0.04);
                margin-bottom: 32px;
                max-width: 1200px;
                width: 100%;
            }
            /* Remove hover animation */
            .modern-form-card:hover {
                box-shadow: 0 8px 32px rgba(75,139,145,0.10), 0 2px 8px rgba(0,0,0,0.04);
                transform: none;
            }
            .table-modern {
                border-radius: 16px;
                overflow: hidden;
                background: #fff;
                box-shadow: 0 4px 24px rgba(75,139,145,0.08), 0 2px 8px rgba(0,0,0,0.04);
                margin-bottom: 24px;
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
