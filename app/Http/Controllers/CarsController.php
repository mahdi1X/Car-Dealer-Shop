<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Car;
use App\Models\Brand;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Recombee\RecommApi\Client;
use Recombee\RecommApi\Requests\{
    AddItem,
    SetItemValues,
    AddItemProperty
};
use App\Enums\StatesEnum;

class CarsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = $request->input('q');

        $cars = Car::query();

        // Filter by name or brand name (main search bar)
        if ($query) {
            $cars->where(function ($q) use ($query) {
                $q->where('name', 'like', "%{$query}%")
                    ->orWhereHas('brand', function ($q2) use ($query) {
                        $q2->where('name', 'like', "%{$query}%");
                    });
            });
        }

        // Filter by color (partial match)
        if ($request->filled('color')) {
            $cars->where('color', 'like', '%' . $request->color . '%');
        }

        // Filter by exact year
        if ($request->filled('year')) {
            $cars->where('year', $request->year);
        }

        // Filter by max price
        if ($request->filled('price')) {
            $cars->where('price', '<=', $request->price);
        }

        // Filter by engine type (partial match)
        if ($request->filled('engine_type')) {
            $cars->where('engine_type', 'like', '%' . $request->engine_type . '%');
        }

        // Filter by exact engine size
        if ($request->filled('engine_size')) {
            $cars->where('engine_size', $request->engine_size);
        }

        // Filter by minimum horsepower
        if ($request->filled('horsepower')) {
            $cars->where('horsepower', '>=', $request->horsepower);
        }

        // Filter by exact seat count
        if ($request->filled('seats')) {
            $cars->where('seats', $request->seats);
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
        // dd($request->all());
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

        // dd($request->all());

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

        $car = Car::create($validatedData);
        // dd($car);
        try {
            $client = new Client(env('RECOMBEE_DATABASE'), env('RECOMBEE_SECRET_TOKEN'), [
                'region' => 'eu-west',
                'timeout' => 10000
            ]);

            // $client->send(new AddItemProperty('color', 'string'));
            // $client->send(new AddItemProperty('engine_type', 'string'));
            // $client->send(new AddItemProperty('engine_size', 'string'));
            // $client->send(new AddItemProperty('seats', 'int'));
            // $client->send(new AddItemProperty('horsepower', 'int'));
            // $client->send(new AddItemProperty('price', 'float'));

            // Add each car (run this once or in a seeder)
            $client->send(new AddItem($car->id));
            $client->send(new SetItemValues($car->id, [
                'color' => $car->color,
                'engine_type' => $car->engine_type,
                'engine_size' => $car->engine_size,
                'seats' => $car->seats,
                'horsepower' => $car->horsepower,
                'price' => $car->price
            ], ['cascadeCreate' => true]));
        } catch (\Exception $e) {
            // Handle any exceptions from Recombee
            // Log the error or handle it as needed
        }

        return redirect()->route('mypage')->with('success', 'Car created successfully.');
    }


    public function show(Car $car, User $user)
    {
        // add flag is_reserver if car->reservations() does not include a pending reservation:
        $isReserved = $car->reservations()->where('state', StatesEnum::PENDING)->exists();
        return view('cars.show', compact('car', 'user', 'isReserved'));
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
        $existingDocs = $car->documents ?? [];
        if ($request->hasFile('documents')) {
            foreach ($request->file('documents') as $doc) {
                $documents[] = $doc->store('documents', 'public');
            }
            $validated['documents'] = array_merge($existingDocs, $documents);
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
