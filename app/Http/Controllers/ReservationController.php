<?php

namespace App\Http\Controllers;

use App\Enums\StatesEnum;
use Illuminate\Http\Request;
use App\Models\Car;
use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class ReservationController extends Controller
{

    public function __construct() {
        // $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reservations = Reservation::with('car')->paginate(10);
        return view("reservations.index", compact("reservations"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request, Car $car)
    {
        return view("reservations.create", compact("car"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            "car_id" => "required",
            "reservation_date" => "required",
        ]);

        $reservation = Reservation::where("car_id", "=", $validatedData['car_id'])->where("user_id", Auth::user()->id)->where("state", "=", StatesEnum::PENDING)->first();

        if ($reservation) {
            return Redirect::back()->with('msg', 'Car already reserved');
        }
        $validatedData['user_id'] = Auth::user()->id;

        $reservation = Reservation::create($validatedData);

        return Redirect::back()->with('msg', 'Reserved Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return view('cars.show', compact('id'));
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
    
    }
    public function cancelReservation(Reservation $reservation){
        $reservation->update(['state' => StatesEnum::CANCELED]);
        return redirect()->route('reservations.index')->with('success', 'Reservation canceled successfully.');
    }
}
