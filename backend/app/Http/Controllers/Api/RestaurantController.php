<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class RestaurantController extends Controller
{
    public function index()
    {
        return response()->json(Restaurant::all());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'album_number' => 'required',
        ]);

        $restaurant = Restaurant::create($validated);

        return response()->json($restaurant, 201);
    }

    public function show(int $id)
    {
        return response()->json(
            Restaurant::findOrFail($id)
        );
    }

    public function update(Request $request, int $id)
    {
        $restaurant = Restaurant::findOrFail($id);

        $validated = $request->validate([
            'name' => 'sometimes|required',
            'latitude' => 'sometimes|required|numeric',
            'longitude' => 'sometimes|required|numeric',
            'album_number' => 'sometimes|required',
        ]);

        $restaurant->update($validated);

        return response()->json($restaurant);
    }

    public function destroy(int $id)
    {
        Restaurant::findOrFail($id)->delete();

        return response()->json(null, 204);
    }

    public function nearby(Request $request)
    {
        $validated = $request->validate([
            'lat' => 'required|numeric',
            'lng' => 'required|numeric',
            'radius' => 'required|numeric|min:0',
        ]);

        $cacheKey = sprintf(
            'nearby:%s:%s:%s',
            $validated['lat'],
            $validated['lng'],
            $validated['radius']
        );

        $results = Cache::remember($cacheKey, 60, function () use ($validated) {

            return Restaurant::all()
                ->map(function ($restaurant) use ($validated) {

                    $distance = $this->distance(
                        $validated['lat'],
                        $validated['lng'],
                        $restaurant->latitude,
                        $restaurant->longitude
                    );

                    $restaurant->distance_km = round($distance, 2);

                    return $restaurant;
                })
                ->filter(function ($restaurant) use ($validated) {
                    return $restaurant->distance_km <= $validated['radius'];
                })
                ->sortBy('distance_km')
                ->values()
                ->toArray();
        });

        return response()->json($results);
    }

    private function distance(
        float $lat1,
        float $lng1,
        float $lat2,
        float $lng2
    ): float {
        $earthRadius = 6371;

        $latDelta = deg2rad($lat2 - $lat1);
        $lngDelta = deg2rad($lng2 - $lng1);

        $a =
            sin($latDelta / 2) * sin($latDelta / 2) +
            cos(deg2rad($lat1)) *
            cos(deg2rad($lat2)) *
            sin($lngDelta / 2) *
            sin($lngDelta / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $earthRadius * $c;
    }
}