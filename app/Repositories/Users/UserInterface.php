<?php

declare(strict_types=1);

namespace App\Repositories\Users;

interface UserInterface
{
    /**
     * Get user has task in progress
     *
     * @return mixed
     */
    public function getUserHasTask();

    /**
     * @return mixed
     */
    public function getListUserForSearch();
}
