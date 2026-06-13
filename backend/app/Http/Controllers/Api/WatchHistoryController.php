<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\WatchHistory;
use Illuminate\Http\JsonResponse;

class WatchHistoryController extends Controller
{
    public function continueWatching(): JsonResponse
    {
        $userId = 1;

        $history = WatchHistory::query()
            ->where('user_id', $userId)
            ->orderByDesc('last_watched_at')
            ->limit(10)
            ->get();

        return response()->json([
            'data' => $history,
        ], 200);
    }
}