<?php

declare(strict_types=1);

namespace App\Services\Users;

use App\Repositories\Users\UserRepository;

class UserService
{
    private $userRepository;

    public function __construct(UserRepository $repository)
    {
        $this->userRepository = $repository;
    }

    public function handle()
    {
        return $this->userRepository->getAll();
    }
}
