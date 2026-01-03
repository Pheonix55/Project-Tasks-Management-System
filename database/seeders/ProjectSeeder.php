<?php

namespace Database\Seeders;

use App\Models\Project;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // Create 5 dummy projects
        for ($i = 1; $i <= 5; $i++) {
            Project::create([
                'name' => $faker->company(),
                'description' => $faker->paragraph(),
            ]);
        }
    }
}
