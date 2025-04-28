<?php

namespace App\Repositories;

use App\Interfaces\TaskRepositoryInterface;
use App\Models\Task;
use Illuminate\Database\Eloquent\Collection;

class TaskRepository implements TaskRepositoryInterface
{
    public function getAllTasks(array $filters = []) : Collection
    {
        $query = Task::query();

        if (!empty($filters['project_id'])) {
            $query->where('project_id', $filters['project_id']);
        }

        return $query->get();
    }
}