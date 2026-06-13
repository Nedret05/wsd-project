<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Watchlist;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class WatchlistController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $userId = 1;

        $exists = Watchlist::query()
            ->where('user_id', $userId)
            ->where('video_id', $request->video_id)
            ->exists();

        if ($exists) {
            return response()->json([
                'message' => 'Video already in watchlist'
            ], 409);
        }

        Watchlist::create([
            'user_id' => $userId,
            'video_id' => $request->video_id,
        ]);

        Cache::forget('recommendations:' . $userId);

        return response()->json([
            'message' => 'Added to watchlist'
        ], 201);
    }

    public function destroy(int $videoId): JsonResponse
    {
        $userId = 1;

        Watchlist::query()
            ->where('user_id', $userId)
            ->where('video_id', $videoId)
            ->delete();

        Cache::forget('recommendations:' . $userId);

        return response()->json([
            'message' => 'Removed from watchlist'
        ]);
    }
}