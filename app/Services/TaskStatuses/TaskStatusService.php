<?php

declare(strict_types=1);

namespace App\Services\TaskStatuses;

use App\Repositories\TaskStatuses\TaskStatusInterface;

class TaskStatusService
{
    private $repository;

    public function __construct(TaskStatusInterface $repository)
    {
        $this->repository = $repository;
    }

    public function handle()
    {
        return $this->repository->getTaskStatuses();
    }
}
