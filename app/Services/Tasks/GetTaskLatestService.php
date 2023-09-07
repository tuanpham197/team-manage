<?php

declare(strict_types=1);

namespace App\Services\Tasks;

use App\Enums\TaskStatusEnum;
use App\Repositories\Tasks\TaskRepository;

class GetTaskLatestService
{
    private $taskRepository;

    public const PERCENT_TASK_NOT_DONE = 0;

    public const PERCENT_TASK_DONE = 100;

    public function __construct(TaskRepository $repository)
    {
        $this->taskRepository = $repository;
    }

    public function handle(int $limitTask = 10, string $field = 'creator_id')
    {
        $tasks = $this->taskRepository->getLatestTaskHasAssign($limitTask, $field)->toArray();

        foreach ($tasks as &$task) {
            $this->calculateProcessPercent($task);
            $this->getListAvatar($task);
        }

        return $tasks;
    }

    private function calculateProcessPercent(&$task)
    {
        $subTasks = $task['sub_tasks'];
        if ($subTasks) {
            $countTaskDone = collect($subTasks)->where('status_id', TaskStatusEnum::DONE)->count();
            $task['process_percent'] = ($countTaskDone / count($subTasks)) * 100;
        } else {
            $task['process_percent'] = $task['status_id'] == TaskStatusEnum::DONE ? self::PERCENT_TASK_DONE : self::PERCENT_TASK_NOT_DONE;
        }
    }

    private function getListAvatar(&$task)
    {
        $subTasks = $task['sub_tasks'];
        $listAvatar = array_filter(array_column(array_column($subTasks, 'assign'), 'avatar'));
        $listAvatar[] = $task['assign']['avatar'];
        $task['list_avatar'] = array_unique($listAvatar) ?? [];
    }
}
