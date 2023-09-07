<?php

declare(strict_types=1);

namespace App\Repositories\Users;

use App\Enums\TaskStatusEnum;
use App\Models\User;
use App\Repositories\AbstractEloquentRepository;

class UserRepository extends AbstractEloquentRepository implements UserInterface
{
    /**
     * Get model
     */
    public function getModel(): string
    {
        // TODO: Implement getModel() method.
        return User::class;
    }

    public function getUserHasTask()
    {
        // TODO: Implement getPostHost() method.
    }

    public function getListUserForSearch()
    {
        // TODO: Implement getListUserForSearch() method.
        return User::select(['id', 'name', 'avatar'])
            ->withCount(['tasks' => function ($query) {
                $query->where('status_id', TaskStatusEnum::PROCESSING);
            }])
            ->whereNotNull('email_verified_at')
            ->orderBy('id')
            ->get();
    }
}
