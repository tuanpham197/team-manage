<?php

declare(strict_types=1);

namespace App\Repositories\TaskStatuses;

use App\Models\Task;
use App\Models\TaskStatus;
use App\Repositories\AbstractEloquentRepository;

class TaskStatusRepository extends AbstractEloquentRepository implements TaskStatusInterface
{
    /**
     * Get model
     */
    public function getModel(): string
    {
        // TODO: Implement getModel() method.
        return TaskStatus::class;
    }

    public function getTaskStatuses()
    {
        // TODO: Implement getPostHost() method.
        return TaskStatus::withCount('tasks')
            ->with([
                'tasks' => function ($query) {
                    $query->withCount('comments')
                        ->withCount('attachments')
                        ->with('tags')
                        ->with([
                            'subTasks.assign',
                            'assign',
                            'order',
                        ]);
                },
            ])
            ->get();

        //        return Task::withCount('comments')->get();
    }
}
