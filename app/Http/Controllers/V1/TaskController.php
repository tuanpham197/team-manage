<?php

declare(strict_types=1);

namespace App\Http\Controllers\V1;

use App\Helpers\ResponseApi;
use App\Http\Controllers\Controller;
use App\Http\Requests\TaskRequest;
use App\Repositories\Tasks\TaskInterface;
use App\Services\Tasks\GetTaskLatestService;
use App\Services\Tasks\TaskService;
use Illuminate\Http\Request;
use Exception;

class TaskController extends Controller
{
    private $repository;

    private $service;

    public const LIMIT_TASK_LATEST = 3;

    public function __construct(TaskInterface $repository, TaskService $service)
    {
        $this->repository = $repository;
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = resolve(TaskService::class)->handle();

        return ResponseApi::responseSuccess($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TaskRequest $request)
    {
        try {
            $input = $request->validated();
            $task = resolve(TaskService::class)->handle($input);

            return ResponseApi::responseSuccess($task);
        } catch (Exception $e) {
            return ResponseApi::responseFail($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = $this->repository->find($id);

        return ResponseApi::responseSuccess($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function order(Request $request)
    {
        $tasks = $request->all();

        if (! resolve(TaskService::class)->order($tasks)) {
            return ResponseApi::responseFail('error');
        }

        return ResponseApi::responseSuccess($tasks);
    }

    public function orderByType(Request $request)
    {
        $payload = $request->all();
        $orderType = $payload['type'] ?? null;
        $statusId = $payload['status_id'] ?? null;
        $direction = $payload['direction'] ?? 'asc';

        if (! resolve(TaskService::class)->orderByType($orderType, $statusId, $direction)) {
            return ResponseApi::responseFail('error');
        }

        return ResponseApi::responseSuccess('');
    }

    public function changeStatus(Request $request)
    {
        $payload = $request->all();
        $taskId = $payload['id'] ?? null;
        $statusId = $payload['status_id'] ?? null;

        if (! resolve(TaskService::class)->changeStatus($taskId, $statusId)) {
            return ResponseApi::responseFail('error');
        }

        return ResponseApi::responseSuccess('');
    }

    public function getTasksLatest(Request $request): \Illuminate\Http\JsonResponse
    {
        $input = $request->only('field');
        $field = $input['field'] ?? 'creator_id';
        $data = resolve(GetTaskLatestService::class)->handle(self::LIMIT_TASK_LATEST, $field);

        return ResponseApi::responseSuccess($data);
    }
}
