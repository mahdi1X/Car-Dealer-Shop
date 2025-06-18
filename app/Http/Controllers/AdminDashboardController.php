<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Brand;
use App\Models\Car;
use App\Models\User;
use App\Models\Reservation;


class AdminDashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

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
    public function show()
    {
        $user = auth()->user();

        if ($user->role === 'admin') {
            // Admin sees all data
            $topBrands = Brand::withCount([
                'cars as reservation_count' => function ($query) {
                    $query->join('reservations', 'cars.id', '=', 'reservations.car_id');
                }
            ])
            
                ->orderByDesc('reservation_count')
                ->take(5)
                ->get(['name']);
                                        
            $topUsers = User::withCount('reservations')
                ->orderByDesc('reservations_count')
                ->take(5)
                ->get(['name']);

            $reservationTrends = Reservation::selectRaw("DATE_FORMAT(created_at, '%Y-%m') as month, COUNT(*) as total")
                ->groupBy('month')
                ->orderBy('month')
                ->get();
        } elseif ($user->role === 'manager') {
            // Manager sees region-specific data
            $topBrands = Brand::withCount([
                'cars as reservation_count' => function ($query) use ($user) {
                    $query->join('reservations', 'cars.id', '=', 'reservations.car_id')
                        ->join('users', 'reservations.user_id', '=', 'users.id')
                        ->where('users.region', $user->region);
                }
            ])
                ->orderByDesc('reservation_count')
                ->take(5)
                ->get(['name']);

            $topUsers = User::where('region', $user->region)
                ->withCount('reservations')
                ->orderByDesc('reservations_count')
                ->take(5)
                ->get(['name']);

            $reservationTrends = Reservation::join('users', 'reservations.user_id', '=', 'users.id')
                ->where('users.region', $user->region)
                ->selectRaw("DATE_FORMAT(reservations.created_at, '%Y-%m') as month, COUNT(*) as total")
                ->groupBy('month')
                ->orderBy('month')
                ->get();
        } else {
            abort(403, 'Unauthorized');
        }

        return view("admin_users.analytics", compact('topBrands', 'topUsers', 'reservationTrends'));
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
