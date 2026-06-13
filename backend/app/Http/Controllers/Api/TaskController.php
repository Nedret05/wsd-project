<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class TaskController extends Controller
{
    public function index()
{
    $tasks = Cache::remember(
        'tasks.index',
        now()->addMinutes(10),
        fn () => Task::all()
    );

    return response()->json($tasks, 200);
}

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'nullable|string',
            'album_number' => 'required|string'
        ]);

        $task = Task::create($validated);

        Cache::forget('tasks.index');

        return response()->json($task, 201);
    }

    public function show($id)
    {
        $task = Task::findOrFail($id);

        return response()->json($task, 200);
    }

    public function update(Request $request, $id)
    {
        $task = Task::findOrFail($id);

        $task->update($request->only([
    'title',
    'description',
    'status',
    'album_number'
]));

Cache::forget('tasks.index');

return response()->json($task, 200);
    }

    public function destroy($id)
    {
        $task = Task::findOrFail($id);

        $task->delete();

Cache::forget('tasks.index');

return response()->noContent();
    }
}