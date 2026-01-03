<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\Task;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        // Get all projects
        $projects = Project::all();

        foreach ($projects as $project) {
            // Create 5-10 tasks for each project
            $taskCount = rand(5, 10);

            for ($i = 1; $i <= $taskCount; $i++) {
                Task::create([
                    'project_id' => $project->id,
                    'name' => $faker->sentence(3),  // Random 3-word task name
                    'priority' => $i,              // Sequential priority
                ]);
            }
        }
    }
}
