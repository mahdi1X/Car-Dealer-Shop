<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Car;
use App\Models\Brand;
use Illuminate\Support\Facades\Auth;

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
            // ->orWhere('description', 'like', "%{$query}%");
            // You can add more fields as needed
        }

        // $cars = $cars->paginate(10); // or ->get() if you don't need pagination
        $cars = $cars->get(); // or ->get() if you don't need pagination

        return view('cars.index', compact('cars', 'query'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'color' => 'required',
            'brand_id' => 'required',
            'year' => 'required|integer',
            'price' => 'numeric',
            'length' => 'numeric',
            'km_recorded' => 'numeric',
            'image' => 'required|file|mimes:jpg,jpeg,png|max:20048',
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('cars', 'public');
            $validatedData['image'] = $imagePath; // Save the file path in the database
        }

        $userId = Auth::user()->id;

        $validatedData['created_by_id'] = $userId;


        $car = Car::create($validatedData);

        return redirect()->route('mypage');
    }

    public function showCreateForm()
    {
        $brands = Brand::all();

        return view("cars.create", compact("brands"));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
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
            'color' => 'required',
            'brand_id' => 'required',
            'year' => 'required|integer',
            'price' => 'numeric',
            'length' => 'numeric',
            'km_recorded' => 'numeric',
            'image' => 'file|mimes:jpg,jpeg,png|max:20048',
        ]);

        $car = Car::where('id', $id)->where('created_by_id', Auth::id())->firstOrFail();



        // Handle image upload if present
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('car_images', 'public');
            $validated['image'] = $imagePath;
        }

        $car->update($validated);

        return redirect()->route('mypage')->with('success', 'Car updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $car = Car::where('id', $id)->where('created_by_id', Auth::id())->firstOrFail();

        // Optionally delete the image from storage
        if ($car->image) {
            \Storage::disk('public')->delete($car->image);
        }

        $car->delete();

        return redirect()->route('mypage')->with('success', 'Car deleted successfully.');
    }
}
