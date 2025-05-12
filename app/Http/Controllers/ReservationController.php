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

    public function __construct()
    {
        // $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //$reservations = Reservation::with('car')->paginate(10);   
        $reservations = Reservation::with('car')
            ->where('user_id', auth()->id())
            ->get();
        $reservations_received = Reservation::whereHas('car', function ($query) {
            $query->where('created_by_id', auth()->id());
        })->get();
        return view("reservations.index", compact("reservations", 'reservations_received'));
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
    
        // Check if the car is already reserved by *any* user with a pending reservation
        $existingReservation = Reservation::where("car_id", $validatedData['car_id'])
            ->where("state", StatesEnum::PENDING)
            ->first();
    
        if ($existingReservation) {
            return Redirect::back()->with('msg', 'Car already reserved');
        }
    
        $validatedData['user_id'] = Auth::id();
    
        Reservation::create($validatedData);
    
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
    public function update(Reservation $reservation)
    {
    }


    /**
     * Remove the specified resource from storage.
     */
    public function view(string $id)
    {
        $reservation = Reservation::with(['car', 'user'])->findOrFail($id);
        return view('reservations.show', compact('reservation'));
    }
    public function cancelReservation(Reservation $reservation)
    {
        $reservation->update(['state' => StatesEnum::CANCELED]);
        return redirect()->route('reservations.index')->with('success', 'Reservation canceled successfully.');
    }
    public function completeReservation(Reservation $reservation)
    {
        $reservation->update(['state' => StatesEnum::COMPLETED]);
        return redirect()->route('reservations.index')->with('success', 'Reservation completed successfully.');
    }
    

}
