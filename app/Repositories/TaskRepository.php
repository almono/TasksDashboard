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

        $query->orderBy('priority', 'ASC');
        return $query->get();
    }

    public function createTask(array $params) : Task
    {
        return Task::create($params);
    }

    public function deleteTask(Task $task) : bool
    {
        return $task->delete();
    }

    public function updateTask(Task $task, array $updatedTask) : bool
    {
        return $task->update($updatedTask);
    }
}