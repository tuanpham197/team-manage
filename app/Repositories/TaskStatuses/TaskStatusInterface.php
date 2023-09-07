<?php

declare(strict_types=1);

namespace App\Repositories\TaskStatuses;

interface TaskStatusInterface
{
    /**
     * Get user has task in progress
     *
     * @return mixed
     */
    public function getTaskStatuses();
}
