<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Car;
use App\Models\Brand;
use Illuminate\Support\Facades\Auth;

class RecommendedController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
    public function show(string $id)
    {
        //
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
    public function recommended()
    {
        $cars = Car::query()->whereNull('created_by_id');
        if (Auth::check()) {
            $cars = $cars->orWhere('created_by_id', '!=', Auth::user()->id);
        }
        $cars = $cars->inRandomOrder()->take(8)->get();
        // dd($cars->count());
        // Check if there are any cars fetched
        if (!$cars->count()) {
            return view('recommended', compact('cars'))->with('message', 'No cars found.');
        }



        return view('recommended', compact('cars'));
    }

}
