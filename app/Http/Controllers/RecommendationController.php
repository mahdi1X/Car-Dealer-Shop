<?php

namespace App\Http\Controllers;
use App\Models\Reservation;
use App\Models\Car;
use Illuminate\Support\Facades\Auth;
use Recombee\RecommApi\Client;
use Recombee\RecommApi\Requests\{
    RecommendItemsToUser,
};

class RecommendationController extends Controller
{
    public function recommended()
    {
        // $userId = Auth::id();

        // // Only fetch reservations where the user is the customer (not the car owner)
        // $reservedCars = Reservation::with('car')
        //     ->where('user_id', $userId)
        //     ->get()
        //     ->pluck('car');

        // if ($reservedCars->isEmpty()) {
        //     // Eager load likes for empty recommendations too
        //     $cars = collect();
        //     return view('recommended', ['cars' => $cars, 'message' => 'No recommendations yet.']);
        // }

        // // Helper to safely get first mode value
        // $firstMode = function ($mode) {
        //     return is_array($mode) ? ($mode[0] ?? null) : $mode;
        // };

        // $preferred = [
        //     'color' => $firstMode($reservedCars->mode('color')),
        //     'engine_type' => $firstMode($reservedCars->mode('engine_type')),
        //     'seats' => $firstMode($reservedCars->mode('seats')),
        //     'engine_size' => round($reservedCars->avg('engine_size'), 1),
        //     'horsepower' => round($reservedCars->avg('horsepower')),
        //     'year' => round($reservedCars->avg('year')),
        //     'price' => round($reservedCars->avg('price')),
        // ];

        // // Exclude cars the user reserved and cars the user owns
        // $ownedCarIds = Car::where('created_by_id', $userId)->pluck('id');
        // $excludeCarIds = $reservedCars->pluck('id')->merge($ownedCarIds)->unique();

        // $otherCars = Car::whereNotIn('id', $excludeCarIds)->get();

        // $recommended = $otherCars->map(function ($car) use ($preferred) {
        //     $score = 0;

        //     if ($car->color == $preferred['color'])
        //         $score += 2;
        //     if ($car->engine_type == $preferred['engine_type'])
        //         $score += 2;
        //     if ($car->seats == $preferred['seats'])
        //         $score += 1;
        //     if (abs($car->engine_size - $preferred['engine_size']) < 0.2)
        //         $score += 1;
        //     if (abs($car->horsepower - $preferred['horsepower']) < 20)
        //         $score += 1;
        //     if (abs($car->price - $preferred['price']) < 1000)
        //         $score += 1;
        //     if (abs($car->year - $preferred['year']) <= 1)
        //         $score += 1;

        //     return ['car' => $car, 'score' => $score];
        // });

        // $recommendedCars = collect($recommended)
        //     ->filter(fn($item) => $item['score'] > 2)
        //     ->sortByDesc('score')
        //     ->pluck('car');

        // // Eager load likes and brand for recommended cars (convert to Eloquent query)
        // $recommendedCars = \App\Models\Car::whereIn('id', $recommendedCars->pluck('id'))
        //     ->withCount(['likes' => function($q) { $q->where('like', 1); }])
        //     ->with('brand')
        //     ->get();

        $client = new Client(env('RECOMBEE_DATABASE'), env('RECOMBEE_SECRET_TOKEN'), [
            'region' => 'eu-west',
            'timeout' => 10000
        ]);

        $userId = Auth::id();
        
        try {
        $response = $client->send(new RecommendItemsToUser($userId, 5));
        // dd(collect($response['recomms'])->pluck('id'));
        $recommendedIds = collect($response['recomms'])->pluck('id');
        $recommendedCars = Car::whereIn('id', $recommendedIds)->withCount('likes')->get();
        } catch (\Exception $e) {
            // Handle the case where no recommendations are found
            return view('recommended', ['cars' => collect(), 'message' => 'No recommendations available at the moment.']);
        }
        return view('recommended', ['cars' => $recommendedCars, 'message' => null]);
    }

}
