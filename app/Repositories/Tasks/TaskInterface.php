<?php

declare(strict_types=1);

namespace App\Repositories\Tasks;

interface TaskInterface
{
    /**
     * Get user has task in progress
     *
     * @return mixed
     */
    public function testTasks();
}
