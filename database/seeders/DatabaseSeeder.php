<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Task;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'codeandcloud',
            'email' => 'naveen@codeandcloud.net',
        ]);
        // User::factory(10)->create();
        Task::factory(20)->create();
    }
}
