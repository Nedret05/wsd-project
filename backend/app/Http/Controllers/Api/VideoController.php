<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Video;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $videos = Video::query()
            ->when($request->genre, function ($query, $genre) {
                $query->where('genre', $genre);
            })
            ->orderByDesc('rating')
            ->paginate(10);

        return response()->json($videos);
    }

    public function show(int $id): JsonResponse
    {
        $video = Video::findOrFail($id);

        return response()->json($video);
    }

    public function store(Request $request): JsonResponse
    {
        $video = Video::create([
            'title' => $request->title,
            'description' => $request->description,
            'genre' => $request->genre,
            'duration_minutes' => $request->duration_minutes,
            'thumbnail_url' => $request->thumbnail_url,
            'video_url' => $request->video_url,
            'rating' => $request->rating ?? 0,
            'album_number' => '79000',
        ]);

        return response()->json($video, 201);
    }
}