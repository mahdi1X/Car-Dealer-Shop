<?php

namespace App\Http\Controllers;
use App\Models\Brand;

class CommonController extends Controller
{

    public function index()
    {
        $brands = Brand::all();
        return view("welcome")->with("brands", $brands);
    }
}