<?php

declare(strict_types=1);

namespace App\Repositories\Tasks;

use App\Enums\TaskStatusEnum;
use App\Models\OrderTask;
use App\Models\Task;
use App\Repositories\AbstractEloquentRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Exception;

class TaskRepository extends AbstractEloquentRepository implements TaskInterface
{
    /**
     * Get model
     */
    public function getModel(): string
    {
        // TODO: Implement getModel() method.
        return Task::class;
    }

    public function testTasks()
    {
        // TODO: Implement getPostHost() method.
    }

    public function saveTask(array $input, array $tagIds): Task
    {
        try {
            DB::beginTransaction();
            // save task first
            $task = Task::create($input);

            // sync tag
            $task->tags()->sync($tagIds);

            $this->createOrderTask($task);

            DB::commit();

            return $task;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    private function createOrderTask($task)
    {
        $lastTask = OrderTask::select(
            'order_tasks.id',
            'after_task_id'
        )
            ->join('tasks', 'order_tasks.task_id', 'tasks.id')
            ->where([
                'status_id' => TaskStatusEnum::OPEN,
                'after_task_id' => null,
                'parent_id' => null,
            ])->first();

        $lastTask->after_task_id = $task->id;
        $lastTask->save();

        OrderTask::create([
            'task_id' => $task->id,
            'before_task_id' => $lastTask->task_id,
        ]);
    }

    public function addSortDefault(Tast $task)
    {
        $taskLatest = Task::where('status_id', TaskStatusEnum::OPEN)
            ->orderBy('created_at', 'DESC')
            ->first();
        DB::table('order_tasks')->updateOrInsert([
            'task_id' => $task->id,
        ], [
            'before_task_id' => $taskLatest->id,
        ]);
    }

    public function getLatestTaskHasAssign(int $limitTask, string $fieldSearch = 'creator_id')
    {
        $userId = Auth::user()->id;

        return Task::with('subTasks:id,title,parent_id,assignee_id,status_id', 'subTasks.assign:id,avatar', 'creator', 'assign')
            ->where($fieldSearch, $userId)
            ->whereNull('parent_id')
            ->latest()
            ->take($limitTask)
            ->get();
    }
}
