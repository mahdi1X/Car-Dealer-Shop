<?php

namespace App\Http\Controllers;
use App\Models\Reservation;
use App\Models\Car;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class RecommendationController extends Controller
{
    public function recommended()
    {
        $userId = Auth::id();

        $reservedCars = Reservation::with('car')
            ->where('user_id', $userId)
            ->get()
            ->pluck('car');

        if ($reservedCars->isEmpty()) {
            return view('cars.recommended', ['cars' => collect(), 'message' => 'No recommendations yet.']);
        }

        // Helper to safely get first mode value
        $firstMode = function ($mode) {
            return is_array($mode) ? ($mode[0] ?? null) : $mode;
        };

        $preferred = [
            'color' => $firstMode($reservedCars->mode('color')),
            'engine_type' => $firstMode($reservedCars->mode('engine_type')),
            'seats' => $firstMode($reservedCars->mode('seats')),
            'engine_size' => round($reservedCars->avg('engine_size'), 1),
            'horsepower' => round($reservedCars->avg('horsepower')),
            'year' => round($reservedCars->avg('year')),
            'price' => round($reservedCars->avg('price')),
        ];

        $otherCars = Car::whereNotIn('id', $reservedCars->pluck('id'))->get();

        $recommended = $otherCars->map(function ($car) use ($preferred) {
            $score = 0;

            if ($car->color == $preferred['color'])
                $score += 2;
            if ($car->engine_type == $preferred['engine_type'])
                $score += 2;
            if ($car->seats == $preferred['seats'])
                $score += 1;
            if (abs($car->engine_size - $preferred['engine_size']) < 0.2)
                $score += 1;
            if (abs($car->horsepower - $preferred['horsepower']) < 20)
                $score += 1;
            if (abs($car->price - $preferred['price']) < 1000)
                $score += 1;
            if (abs($car->year - $preferred['year']) <= 1)
                $score += 1;

            return ['car' => $car, 'score' => $score];
        });

        $recommendedCars = collect($recommended)
            ->filter(fn($item) => $item['score'] > 2)
            ->sortByDesc('score')
            ->pluck('car');

        return view('recommended', ['cars' => $recommendedCars, 'message' => null]);
    }

}
