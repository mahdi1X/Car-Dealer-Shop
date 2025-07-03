<?php

namespace App\Http\Controllers;
use App\Models\Reservation;
use App\Models\Car;
use Illuminate\Support\Facades\Auth;
use Recombee\RecommApi\Client;
use Recombee\RecommApi\Requests\{
    RecommendItemsToUser,
};
use Illuminate\Support\Facades\Log;

class RecommendationController extends Controller
{
    public function recommended()
    {
        $client = new Client(env('RECOMBEE_DATABASE'), env('RECOMBEE_SECRET_TOKEN'), [
            'region' => 'eu-west',
            'timeout' => 10000
        ]);

        $userId = Auth::id();

        // Check if user has any reservations (i.e., has interacted with cars)
        $hasReservations = \App\Models\Reservation::where('user_id', $userId)->exists();

       

        try {
            $response = $client->send(new RecommendItemsToUser($userId, 6, [
                // 'returnProperties' => true,
                // 'diversity' => 0.0,
                'minRelevance' => 'low', // 'low', 'medium', 'high'
                // 'rotationRate' => 0.5,
                // 'rotationTime' => 3600,
                // 'allowRepetition' => false,
            ]));

            $recommendedIds = collect($response['recomms'])->pluck('id')->map(fn($id) => (int)$id);
            Log::error(message: 'recommendedIds: ' . $recommendedIds);

            // If no recommendations, show nothing (do not fill with random cars)
            if ($recommendedIds->isEmpty()) {
                return view('recommended', [
                    'cars' => collect(),
                    'message' => 'No AI recommendations available at the moment.'
                ]);
            }

            $recommendedCars = \App\Models\Car::whereIn('id', $recommendedIds)
                ->withCount('likes')
                ->with('brand')
                ->get()
                ->sortBy(function($car) use ($recommendedIds) {
                    return array_search($car->id, $recommendedIds->toArray());
                })
                ->values();
            Log::error(message: 'recommendedCars: ' . $recommendedCars);

        } catch (\Exception $e) {
            Log::error(message: 'Recombee error: ' . $e->getMessage());
            // If Recombee returns an error (e.g., user not found), show nothing
            return view('recommended', [
                'cars' => collect(),
                'message' => 'No AI recommendations available at the moment.'
            ]);
        }
        return view('recommended', ['cars' => $recommendedCars, 'message' => null]);
    }

}
