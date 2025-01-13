<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Car;
use App\Models\Brand;

class CarsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cars = Car::all();
        
        return view("brands.show", compact("cars"));
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
            'image' => 'required|file|mimes:jpg,jpeg,png|max:20048',
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('cars', 'public');
            $validatedData['image'] = $imagePath; // Save the file path in the database
        }


        $car = Car::create($validatedData);

        return redirect()->route('cars.index');
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
