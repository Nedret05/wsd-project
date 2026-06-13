<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Task;

class TaskSeeder extends Seeder
{
    public function run(): void
    {
        Task::truncate();

        Task::insert([
            [
                'title' => 'Task 1',
                'description' => 'First seeded task',
                'status' => 'todo',
                'album_number' => '1001',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Task 2',
                'description' => 'Second seeded task',
                'status' => 'in_progress',
                'album_number' => '1002',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Task 3',
                'description' => 'Third seeded task',
                'status' => 'done',
                'album_number' => '1003',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}