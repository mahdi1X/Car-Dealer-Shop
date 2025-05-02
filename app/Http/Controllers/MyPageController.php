<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MyPageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //    return view('mypage');
        // $firstBrand = \App\Models\Brand::first();
        // if ($firstBrand) {

        // return redirect()->route('brands.show', ['brand' => $firstBrand->id]);
        // }

        $user = Auth::user();

        $cars = Car::where('created_by_id', $user->id)->get();
        return view('mypage', compact('cars'));

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

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
    }

}
