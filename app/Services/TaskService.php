<?php

namespace App\Services;

use App\Models\Task;
use App\Repositories\TaskRepository;
use Illuminate\Database\Eloquent\Collection;

class TaskService
{
    public function __construct(
        private TaskRepository $taskRepository
    ) {}

    public function getAllTasks(array $filters = []) : Collection
    {
        return $this->taskRepository->getAllTasks($filters);
    }

    public function createTask(array $params) : Task
    {
        return $this->taskRepository->createTask($params);
    }

    public function deleteTask(Task $task) : bool
    {
        return $this->taskRepository->deleteTask($task);
    }

    public function updateTask(Task $task, array $updatedTask) : bool
    {
        return $this->taskRepository->updateTask($task, $updatedTask);
    }
}