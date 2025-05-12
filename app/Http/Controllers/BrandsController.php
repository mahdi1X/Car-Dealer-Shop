<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Brand;
use App\Models\Car;

class BrandsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $brands = Brand::all();
        return view('brands.index', compact('brands'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("brands.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'icon' => 'required|file|mimes:jpg,jpeg,png|max:20048',
        ]);

        if ($request->hasFile('icon')) {
            $imagePath = $request->file('icon')->store('brands', 'public');
            $validatedData['icon'] = $imagePath; // Save the file path in the database
        }


        $brand = Brand::create($validatedData);

        return redirect()->route(route: 'brands.create');
    }


    /**
     * Display the specified resource.
     */
    public function show(Brand $brand)
    {
        // $cars = Car::where('brand_id', '=', $brand->id)->get();
        // $cars = $brand->cars;
        // dd();

        return view('brands.show', compact('brand'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $brand = Brand::findOrFail($id);
        return view('brands.create', compact('brand'));
    }
    

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $brand = Brand::findOrFail($id);
    
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'icon' => 'nullable|file|mimes:jpg,jpeg,png|max:20048',
        ]);
    
        if ($request->hasFile('icon')) {
            $imagePath = $request->file('icon')->store('brands', 'public');
            $validatedData['icon'] = $imagePath;
        }
    
        $brand->update($validatedData);
    
        return redirect()->route('brands.index')->with('success', 'Brand updated successfully.');
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
