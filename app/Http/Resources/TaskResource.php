<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Helpers\Helper;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

class TaskResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|JsonSerializable
     */
    public function toArray($request)
    {
        $subTasks = $this->whenLoaded('subTasks')->toArray();
        $order = $this->whenLoaded('order');
        $listAvatar = Helper::getListAvatar($subTasks);

        $task = parent::toArray($request);
        unset($task['order'], $task['assign']);


        return array_merge($task, [
            'list_avatar' => $listAvatar,
            'after_task_id' => $order->after_task_id ?? null,
            'before_task_id' => $order->before_task_id ?? null,
        ]);
    }
}
