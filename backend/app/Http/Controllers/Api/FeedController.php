<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Follow;
use App\Models\Photo;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class FeedController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $userId = 1;

        $limit = (int) $request->query('limit', 10);

        $cacheKey = 'feed:' . $userId . ':' . $limit;

        $feed = Cache::remember($cacheKey, 60, function () use ($userId, $limit) {

            return Photo::query()
    ->orderByDesc('created_at')
    ->limit($limit)
    ->get()
    ->unique('id')
    ->values();
        });

        return response()->json([
            'count' => $feed->count(),
            'data' => $feed,
        ], 200);
    }
}