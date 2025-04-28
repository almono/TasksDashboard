<?php

namespace Database\Factories;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->sentence,
            'description' => substr(fake()->paragraph, 0, 150),
            'project_id' => function () {
                return Project::factory()->create()->id; // Assign to a project
            },
            'priority' => function (array $task) {
                // We assign priority 1 by 1 for each project
                $maxPriority = Task::where('project_id', $task['project_id'])->max('priority');
                return $maxPriority + 1;
            },
        ];
    }
}
