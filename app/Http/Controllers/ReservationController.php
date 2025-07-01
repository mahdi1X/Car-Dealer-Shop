<?php

namespace App\Http\Controllers;

use App\Enums\StatesEnum;
use Illuminate\Http\Request;
use App\Models\Car;
use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Recombee\RecommApi\Client;
use Recombee\RecommApi\Requests\{
    AddPurchase,
    AddUser,
    AddItem

};
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

        $reservation = Reservation::create($validatedData);

        $client = new Client(env('RECOMBEE_DATABASE'), env('RECOMBEE_SECRET_TOKEN'), [
            'region' => 'eu-west',
            'timeout' => 10000
        ]);

        try {
            // Recombee expects string IDs, not integers
            $userId = (string) $validatedData['user_id'];
            $carId = (string) $validatedData['car_id'];

            // Ensure user exists in Recombee
            // $client->send(new AddUser($userId));
            // Ensure car exists in Recombee
            // $client->send(new AddItem($carId));
            // Register the purchase (reservation) in Recombee
            $client->send(new AddPurchase($userId, $carId));
        } catch (\Exception $e) {
            Log::error(message: 'Recombee error: ' . $e->getMessage());
        }
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
        // Remove from Recombee
        try {
            $client = new \Recombee\RecommApi\Client(env('RECOMBEE_DATABASE'), env('RECOMBEE_SECRET_TOKEN'), [
                'region' => 'eu-west',
                'timeout' => 10000
            ]);
            $client->send(new \Recombee\RecommApi\Requests\DeletePurchase($reservation->user_id, $reservation->car_id));
        } catch (\Exception $e) {
            // Optionally log error
        }
        $reservation->delete();
        return redirect()->route('reservations.index')->with('success', 'Reservation canceled successfully.');
    }

    public function completeReservation(Reservation $reservation)
    {
        $reservation->update(['state' => StatesEnum::COMPLETED]);
        // Remove from Recombee
        try {
            $client = new \Recombee\RecommApi\Client(env('RECOMBEE_DATABASE'), env('RECOMBEE_SECRET_TOKEN'), [
                'region' => 'eu-west',
                'timeout' => 10000
            ]);
            $client->send(new \Recombee\RecommApi\Requests\DeletePurchase($reservation->user_id, $reservation->car_id));
        } catch (\Exception $e) {
            // Optionally log error
        }
        $reservation->delete();
        return redirect()->route('reservations.index')->with('success', 'Reservation completed successfully.');
    }
    public function calendar()
    {
        return view('reservations.calendar');
    }

    public function calendarEvents()
    {
        try {
            \Log::info('calendarEvents called by user: ' . Auth::id());

            $userId = Auth::id();

            $reservations = Reservation::with(['car.brand'])
                ->where(function ($query) use ($userId) {
                    $query->where('user_id', $userId)
                        ->orWhereHas('car', function ($q) use ($userId) {
                            $q->where('created_by_id', $userId);
                        });
                })
                ->whereIn('state', [
                    StatesEnum::PENDING,
                    StatesEnum::COMPLETED,
                ])
                ->get();

            \Log::info('Reservations fetched: ', $reservations->toArray());

            $events = $reservations->map(function ($reservation) {
                if (!$reservation->car || !$reservation->car->brand) {
                    return null;
                }

                return [
                    'id' => $reservation->id,
                    'title' => $reservation->car->name . ' - ' . $reservation->car->model,
                    'start' => \Carbon\Carbon::parse($reservation->reservation_date)->toDateString(),
                    'end' => \Carbon\Carbon::parse($reservation->reservation_date)->addDay()->toDateString(),
                    // 'color' => $reservation->state === StatesEnum::COMPLETED ? '#28a745' : '#4b8b91',
                    'color' => $reservation->user_id === Auth::id() ? '#4b8b91' : '#28a745',
                    'textColor' => '#ffffff',
                    'extendedProps' => [
                        'state' => $reservation->state,
                    ]
                ];
            })->filter()->values();

            \Log::info('Events returned: ', $events->toArray());

            return response()->json($events->toArray());
        } catch (\Exception $e) {
            \Log::error('Error fetching calendar events: ' . $e->getMessage());
            return response()->json(['error' => 'Could not load events.'], 500);
        }
    }




}
