<?php

namespace App\Services;

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
}