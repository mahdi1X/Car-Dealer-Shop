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

            // Reservations by region (use car owner's region)
            $reservationsByRegion = Reservation::join('cars', 'reservations.car_id', '=', 'cars.id')
                ->join('users as owners', 'cars.created_by_id', '=', 'owners.id')
                ->selectRaw('owners.region as region, COUNT(*) as total')
                ->groupBy('owners.region')
                ->orderByDesc('total')
                ->get()
                ->pluck('total', 'region');

            // Reservations by user region (region of the reserving user)
            $reservationsByUserRegion = Reservation::join('users', 'reservations.user_id', '=', 'users.id')
                ->selectRaw('users.region as region, COUNT(*) as total')
                ->groupBy('users.region')
                ->orderByDesc('total')
                ->get()
                ->pluck('total', 'region');

            // Reservations by car model
            $topModels = Car::withCount('reservations')
                ->orderByDesc('reservations_count')
                ->take(10)
                ->get(['model', 'reservations_count']);

            // User growth over time
            $userGrowth = User::selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, COUNT(*) as total')
                ->groupBy('month')
                ->orderBy('month')
                ->get();

            // Reservation status distribution
            $stateCounts = Reservation::selectRaw('state, COUNT(*) as total')
                ->groupBy('state')
                ->pluck('total', 'state');

            // Average reservation value by brand
            $avgPriceByBrand = Brand::with(['cars.reservations'])
                ->get()
                ->mapWithKeys(function($brand) {
                    // Only consider cars that have at least one reservation
                    $carsWithReservations = $brand->cars->filter(function($car) {
                        return $car->reservations->count() > 0;
                    });
                    $avg = $carsWithReservations->avg('price');
                    return [$brand->name => $avg];
                });

            // Reservations by payment method (admin: all)
            $reservationsByPaymentMethod = Reservation::join('users', 'reservations.user_id', '=', 'users.id')
                ->selectRaw('users.payment_method as method, COUNT(*) as total')
                ->groupBy('users.payment_method')
                ->orderByDesc('total')
                ->get()
                ->pluck('total', 'method');

            // Reservations per Month by State (admin: all)
            $states = \App\Enums\StatesEnum::cases();
            $months = Reservation::selectRaw("DATE_FORMAT(created_at, '%Y-%m') as month")
                ->groupBy('month')
                ->orderBy('month')
                ->pluck('month')
                ->toArray();

            $datasets = [];
            foreach ($states as $state) {
                $data = [];
                foreach ($months as $month) {
                    $count = Reservation::whereRaw("DATE_FORMAT(created_at, '%Y-%m') = ?", [$month])
                        ->where('state', $state->value)
                        ->count();
                    $data[] = $count;
                }
                $datasets[] = [
                    'label' => $state->value,
                    'data' => $data,
                    'backgroundColor' => match($state->value) {
                        'pending' => '#FFC107',
                        'completed' => '#4CAF50',
                        'canceled' => '#EF5350',
                        default => '#2196F3'
                    },
                    'borderColor' => match($state->value) {
                        'pending' => '#FFC107',
                        'completed' => '#4CAF50',
                        'canceled' => '#EF5350',
                        default => '#2196F3'
                    },
                    'fill' => false
                ];
            }
            $reservationsPerMonthByState = [
                'labels' => $months,
                'datasets' => $datasets
            ];
        } elseif ($user->role === 'manager') {
            // Manager sees region-specific data
            $topBrands = Brand::withCount([
                'cars as reservation_count' => function ($query) use ($user) {
                    $query->join('reservations', 'cars.id', '=', 'reservations.car_id')
                        ->join('users as owners', 'cars.created_by_id', '=', 'owners.id')
                        ->where('owners.region', $user->region);
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

            // Reservations by region (manager's region, use car owner's region)
            $reservationsByRegion = Reservation::join('cars', 'reservations.car_id', '=', 'cars.id')
                ->join('users as owners', 'cars.created_by_id', '=', 'owners.id')
                ->join('users', 'reservations.user_id', '=', 'users.id')
                ->where('users.region', $user->region)
                ->selectRaw('owners.region as region, COUNT(*) as total')
                ->groupBy('owners.region')
                ->orderByDesc('total')
                ->get()
                ->pluck('total', 'region');

            // Reservations by user region (only for manager's region)
            $reservationsByUserRegion = Reservation::join('users', 'reservations.user_id', '=', 'users.id')
                ->where('users.region', $user->region)
                ->selectRaw('users.region as region, COUNT(*) as total')
                ->groupBy('users.region')
                ->orderByDesc('total')
                ->get()
                ->pluck('total', 'region');

            // Reservations by car model (manager's region)
            $topModels = Car::whereHas('reservations.user', function($q) use ($user) {
                    $q->where('region', $user->region);
                })
                ->withCount(['reservations' => function($q) use ($user) {
                    $q->whereHas('user', function($q2) use ($user) {
                        $q2->where('region', $user->region);
                    });
                }])
                ->orderByDesc('reservations_count')
                ->take(10)
                ->get(['model', 'reservations_count']);

            // User growth over time (manager's region)
            $userGrowth = User::where('region', $user->region)
                ->selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, COUNT(*) as total')
                ->groupBy('month')
                ->orderBy('month')
                ->get();

            // Reservation status distribution (manager's region)
            $stateCounts = Reservation::whereHas('user', function($q) use ($user) {
                    $q->where('region', $user->region);
                })
                ->selectRaw('state, COUNT(*) as total')
                ->groupBy('state')
                ->pluck('total', 'state');

            // Average reservation value by brand (manager's region)
            $avgPriceByBrand = Brand::with(['cars.reservations' => function($q) use ($user) {
                $q->whereHas('user', function($q2) use ($user) {
                    $q2->where('region', $user->region);
                });
            }])->get()->mapWithKeys(function($brand) {
                // Only consider cars that have at least one reservation (in this region)
                $carsWithReservations = $brand->cars->filter(function($car) {
                    return $car->reservations->count() > 0;
                });
                $avg = $carsWithReservations->avg('price');
                return [$brand->name => $avg];
            });

            // Reservations by payment method (manager: only their region)
            $reservationsByPaymentMethod = Reservation::join('users', 'reservations.user_id', '=', 'users.id')
                ->where('users.region', $user->region)
                ->selectRaw('users.payment_method as method, COUNT(*) as total')
                ->groupBy('users.payment_method')
                ->orderByDesc('total')
                ->get()
                ->pluck('total', 'method');

            // Reservations per Month by State (manager: only their region)
            $states = \App\Enums\StatesEnum::cases();
            $months = Reservation::join('users', 'reservations.user_id', '=', 'users.id')
                ->where('users.region', $user->region)
                ->selectRaw("DATE_FORMAT(reservations.created_at, '%Y-%m') as month")
                ->groupBy('month')
                ->orderBy('month')
                ->pluck('month')
                ->toArray();

            $datasets = [];
            foreach ($states as $state) {
                $data = [];
                foreach ($months as $month) {
                    $count = Reservation::join('users', 'reservations.user_id', '=', 'users.id')
                        ->where('users.region', $user->region)
                        ->whereRaw("DATE_FORMAT(reservations.created_at, '%Y-%m') = ?", [$month])
                        ->where('state', $state->value)
                        ->count();
                    $data[] = $count;
                }
                $datasets[] = [
                    'label' => $state->value,
                    'data' => $data,
                    'backgroundColor' => match($state->value) {
                        'pending' => '#FFC107',
                        'completed' => '#4CAF50',
                        'canceled' => '#EF5350',
                        default => '#2196F3'
                    },
                    'borderColor' => match($state->value) {
                        'pending' => '#FFC107',
                        'completed' => '#4CAF50',
                        'canceled' => '#EF5350',
                        default => '#2196F3'
                    },
                    'fill' => false
                ];
            }
            $reservationsPerMonthByState = [
                'labels' => $months,
                'datasets' => $datasets
            ];
        } else {
            abort(403, 'Unauthorized');
        }

        return view("admin_users.analytics", compact(
            'topBrands',
            'topUsers',
            'reservationTrends',
            'reservationsByRegion',
            'userGrowth',
            'stateCounts',
            'avgPriceByBrand',
            'reservationsPerMonthByState'
        ));
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
