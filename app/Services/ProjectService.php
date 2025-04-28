<?php

namespace App\Services;

use App\Repositories\ProjectRepository;
use Illuminate\Database\Eloquent\Collection;

class ProjectService
{
    public function __construct(
        private ProjectRepository $projectRepository
    ) {}

    public function getAllProjectsWithTasks() : Collection
    {
        return $this->projectRepository->getAllProjectsWithTasks();
    }
}