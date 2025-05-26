<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Car;
use App\Models\Brand;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CarsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = $request->input('q');

        $cars = Car::query();

        if ($query) {
            $cars->where('name', 'like', "%{$query}%")
                ->orWhereHas('brand', function ($q2) use ($query) {
                    $q2->where('name', 'like', "%{$query}%");
                });
        }

        $cars = $cars->get();

        return view('cars.index', compact('cars', 'query'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function showCreateForm()
    {
        $brands = Brand::all();
        return view("cars.create", compact("brands"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function create(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'color' => 'required|string|max:255',
            'brand_id' => 'required|exists:brands,id',
            'year' => 'required|integer',
            'price' => 'nullable|numeric',
            'length' => 'nullable|numeric',
            'km_recorded' => 'nullable|numeric',

            // Basic & Performance Specs
            'transmission' => 'nullable|string|max:255',
            'engine_type' => 'nullable|string|max:255',
            'engine_size' => 'nullable|string|max:255',
            'horsepower' => 'nullable|integer',
            'torque' => 'nullable|integer',
            'drivetrain' => 'nullable|string|max:255',
            'fuel_type' => 'nullable|string|max:255',
            'fuel_economy' => 'nullable|string|max:255',

            // Features & Options
            'body_type' => 'nullable|string|max:255',
            'seats' => 'nullable|integer',
            'doors' => 'nullable|integer',
            'interior_color' => 'nullable|string|max:255',
            'features' => 'nullable|array',
            'features.*' => 'string|max:255',
            'new_features' => 'nullable|string|max:1000',
            'safety_rating' => 'nullable|string|max:255',

            // History & Condition
            'condition' => 'nullable|string|max:255',
            'service_history' => 'nullable|string',
            'accident_history' => 'nullable|string',
            'ownership_count' => 'nullable|integer',
            'registration_valid_till' => 'nullable|date',

            // Location & Logistics
            'location' => 'nullable|string|max:255',
            'delivery_available' => 'nullable|boolean',
            'available_from' => 'nullable|date',

            // Media & Documentation
            'video' => 'nullable|file|mimes:mp4,mov,avi|max:50000',
            'documents.*' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'gallery_images.*' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',

            // Main image
            'image' => 'required|file|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Handle main image
        $validatedData['image'] = $request->file('image')->store('cars', 'public');

        // Handle video
        if ($request->hasFile('video')) {
            $validatedData['video'] = $request->file('video')->store('videos', 'public');
        }

        // Handle documents
        $documents = [];
        if ($request->hasFile('documents')) {
            foreach ($request->file('documents') as $doc) {
                $documents[] = $doc->store('documents', 'public');
            }
        }
        $validatedData['documents'] = $documents;

        // Handle gallery images
        $galleryPaths = [];

        if ($request->hasFile('gallery_images')) {
            foreach ($request->file('gallery_images') as $img) {
                if ($img->isValid()) {
                    $galleryPaths[] = $img->store('gallery', 'public');
                }
            }
        }

        // Store encoded array in DB
        $validatedData['gallery_images'] = json_encode($galleryPaths);
        // <-- This is an array



        // Merge features checkbox array + new features comma-separated string
        $features = $request->input('features', []);
        $newFeaturesInput = $request->input('new_features', '');
        $newFeatures = array_filter(array_map('trim', explode(',', $newFeaturesInput)));
        $allFeatures = array_unique(array_merge($features, $newFeatures));
        $validatedData['features'] = json_encode($allFeatures);

        $validatedData['created_by_id'] = Auth::id();

        Car::create($validatedData);

        return redirect()->route('mypage')->with('success', 'Car created successfully.');
    }


    public function show(Car $car)
    {
        return view('cars.show', compact('car'));
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Car $car)
    {
        $brands = Brand::all();
        return view('cars.create', compact('car', 'brands'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'color' => 'required|string|max:255',
            'brand_id' => 'required|exists:brands,id',
            'year' => 'required|integer',
            'price' => 'nullable|numeric',
            'length' => 'nullable|numeric',
            'km_recorded' => 'nullable|numeric',

            // Basic & Performance Specs
            'transmission' => 'nullable|string|max:255',
            'engine_type' => 'nullable|string|max:255',
            'engine_size' => 'nullable|string|max:255',
            'horsepower' => 'nullable|integer',
            'torque' => 'nullable|integer',
            'drivetrain' => 'nullable|string|max:255',
            'fuel_type' => 'nullable|string|max:255',
            'fuel_economy' => 'nullable|string|max:255',

            // Features & Options
            'body_type' => 'nullable|string|max:255',
            'seats' => 'nullable|integer',
            'doors' => 'nullable|integer',
            'interior_color' => 'nullable|string|max:255',
            'features' => 'nullable|array',
            'features.*' => 'string|max:255',
            'new_features' => 'nullable|string|max:1000',
            'safety_rating' => 'nullable|string|max:255',

            // History & Condition
            'condition' => 'nullable|string|max:255',
            'service_history' => 'nullable|string',
            'accident_history' => 'nullable|string',
            'ownership_count' => 'nullable|integer',
            'registration_valid_till' => 'nullable|date',

            // Location & Logistics
            'location' => 'nullable|string|max:255',
            'delivery_available' => 'nullable|boolean',
            'available_from' => 'nullable|date',

            // Media & Documentation
            'video' => 'nullable|file|mimes:mp4,mov,avi|max:50000',
            'documents.*' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'gallery_images.*' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',

            // Main image
            'image' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
        ]);

        $car = Car::where('id', $id)->where('created_by_id', Auth::id())->firstOrFail();

        // Main image
        if ($request->hasFile('image')) {
            if ($car->image) {
                Storage::disk('public')->delete($car->image);
            }
            $validated['image'] = $request->file('image')->store('cars', 'public');
        }

        // Video
        if ($request->hasFile('video')) {
            if ($car->video) {
                Storage::disk('public')->delete($car->video);
            }
            $validated['video'] = $request->file('video')->store('videos', 'public');
        }

        // Documents
        $documents = [];
        if ($request->hasFile('documents')) {
            foreach ($request->file('documents') as $doc) {
                $documents[] = $doc->store('documents', 'public');
            }
            $validated['documents'] = $documents;
        }

        $galleryPaths = [];
        if ($request->hasFile('gallery_images')) {
            foreach ($request->file('gallery_images') as $img) {
                if ($img->isValid()) {
                    $galleryPaths[] = $img->store('gallery', 'public');
                }
            }
        }

        // Optional: Merge with existing gallery images if needed
        // $existingGallery = json_decode($car->gallery_images, true) ?? [];
        // $galleryPaths = array_merge($existingGallery, $galleryPaths);

        if (count($galleryPaths) > 0) {
            $validated['gallery_images'] = json_encode($galleryPaths);
        }

        // Merge features array and new features string, then encode as JSON
        $features = $request->input('features', []);
        $newFeaturesInput = $request->input('new_features', '');
        $newFeatures = array_filter(array_map('trim', explode(',', $newFeaturesInput)));
        $allFeatures = array_unique(array_merge($features, $newFeatures));
        $validated['features'] = json_encode($allFeatures);

        $car->update($validated);

        return redirect()->route('mypage')->with('success', 'Car updated successfully.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $car = Car::where('id', $id)->where('created_by_id', Auth::id())->firstOrFail();

        // Delete image & video from storage if they exist
        if ($car->image) {
            Storage::disk('public')->delete($car->image);
        }
        if ($car->video) {
            Storage::disk('public')->delete($car->video);
        }

        $car->delete();

        return redirect()->route('mypage')->with('success', 'Car deleted successfully.');
    }

    public function myLikedCars()
    {
        $likedCars = auth()->user()->likedCars()->with('brand')->get();

        return view('cars.my_liked', compact('likedCars'));
    }

    /**
     * Helper method to decode JSON if input is string, else return as is or null.
     */
    private function jsonDecodeIfNeeded($input)
    {
        if (is_null($input) || $input === '') {
            return ["", "", ""]; // Provide empty array with 3 slots
        }

        if (is_string($input)) {
            $decoded = json_decode($input, true);
            return $decoded === null ? ["", "", ""] : $decoded;
        }

        return is_array($input) ? $input : ["", "", ""];
    }

}
