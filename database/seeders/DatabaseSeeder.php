<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create 5 projects
        $projects = Project::factory(5)->create(); 

        // For each project, create 1 to 5 tasks
        $projects->each(function ($project) {
            Task::factory(rand(1, 5))->create(['project_id' => $project->id]);
        });

        // Create 1 project with no tasks associated
        $projects = Project::factory(1)->create(); 
    }
}
