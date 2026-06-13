<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Photo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class PhotoController extends Controller
{
    public function index()
    {
        return response()->json(
            Cache::remember('photos.index', 60, function () {
                return Photo::all()->map(function ($photo) {
                    $photo->image_url = url('/storage/' . $photo->image_path);
                    return $photo;
                });
            })
        );
    }

    public function show(int $id)
    {
        return response()->json(
            Cache::remember("photos.show.{$id}", 60, function () use ($id) {

                $photo = Photo::findOrFail($id);

                $photo->image_url = url('/storage/' . $photo->image_path);

                return $photo;
            })
        );
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'caption' => 'nullable|string',
            'image' => 'required|image|max:10240',
            'album_number' => 'required',
        ]);

        $path = $request->file('image')->store('photos', 'public');

        $photo = Photo::create([
            'title' => $validated['title'],
            'caption' => $validated['caption'] ?? null,
            'image_path' => $path,
            'original_filename' => $request->file('image')->getClientOriginalName(),
            'mime_type' => $request->file('image')->getMimeType(),
            'file_size' => $request->file('image')->getSize(),
            'processing_status' => 'uploaded',
            'album_number' => $validated['album_number'],
        ]);

        $photo->processing_status = 'processed';
        $photo->save();

        Cache::forget('photos.index');

        return response()->json($photo, 201);
    }

    public function destroy(int $id)
    {
        $photo = Photo::findOrFail($id);

        Cache::forget('photos.index');
        Cache::forget("photos.show.{$id}");

        $photo->delete();

        return response()->json(null, 204);
    }
}