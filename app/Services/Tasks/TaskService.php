<?php

declare(strict_types=1);

namespace App\Services\Tasks;

use App\Models\Task;
use App\Repositories\Tasks\TaskInterface;
use App\Repositories\TaskStatuses\TaskStatusInterface;
use Exception;
use Illuminate\Support\Facades\DB;
use App\Enums\TaskStatusEnum;
use Illuminate\Support\Facades\Auth;

class TaskService
{
    private $taskRepository;

    private $taskStatusRepository;

    public function __construct(TaskInterface $taskRepository, TaskStatusInterface $taskStatusRepository)
    {
        $this->taskRepository = $taskRepository;
        $this->taskStatusRepository = $taskStatusRepository;
    }

    public function handle(array $data)
    {
        $taskInput = [
            'title' => $data['title'] ?? null,
            'description' => $data['description'] ?? null,
            'status_id' => TaskStatusEnum::OPEN,
            'creator_id' => Auth::user()->id,
            'assignee_id' => $data['assignee_id'] ?? null,
        ];

        $tagIds = $data['tag_ids'] ?? [];

        return $this->taskRepository->saveTask($taskInput, $tagIds);
    }

    public function order(array $tasks)
    {
        try {
            DB::beginTransaction();

            $statusIds = array_unique(array_column($tasks, 'status_id'));

            foreach ($statusIds as $statusId) {
                $taskStatus = TaskStatusEnum::where('id', $statusId)->sharedLock()->first();
                $taskStatus->sort_task_by = null;
                $taskStatus->sort_task_direction = null;
                $taskStatus->save();
            }

            foreach ($tasks as $task) {
                DB::table('order_tasks')->updateOrInsert([
                    'task_id' => $task['id'],
                ], [
                    'before_task_id' => $task['before_task_id'] ?? null,
                    'after_task_id' => $task['after_task_id'] ?? null,
                ]);
            }

            DB::commit();

            return true;
        } catch (Exception $e) {
            DB::rollBack();

            return false;
        }
    }

    public function orderByType(string $type, int $statusId, string $direction = 'ASC')
    {
        try {
            $orderField = strtolower($type) . '_at'; // created_at | updated_at
            $tasks = Task::where([
                ['status_id', $statusId],
                ['parent_id', null],
            ])->orderBy($orderField, $direction)->get();

            DB::beginTransaction();
            foreach ($tasks as $key => $task) {
                $beforeTaskId = $tasks[$key - 1]->id ?? null;
                $afterTaskId = $tasks[$key + 1]->id ?? null;

                DB::table('order_tasks')->updateOrInsert([
                    'task_id' => $task->id,
                ], [
                    'before_task_id' => $beforeTaskId,
                    'after_task_id' => $afterTaskId,
                ]);
            }

            $this->taskStatusRepository->update($statusId, [
                'sort_task_by' => $type,
                'sort_task_direction' => $direction,
            ]);

            DB::commit();

            return true;
        } catch (Exception $e) {
            DB::rollBack();

            return false;
        }
    }

    public function changeStatus(int $taskId, int $statusId)
    {
        try {
            DB::beginTransaction();

            $task = Task::where('id', $taskId)->sharedLock()->first();
            $task->status_id = $statusId;
            $result = $task->save();
            DB::commit();

            return $result;
        } catch (Exception $th) {
            DB::rollBack();

            return false;
        }
    }
}
