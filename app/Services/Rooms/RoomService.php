<?php

declare(strict_types=1);

namespace App\Services\Rooms;

use App\Repositories\Rooms\RoomInterface;

class RoomService
{
    private $roomRepository;

    public function __construct(RoomInterface $repository)
    {
        $this->roomRepository = $repository;
    }

    public function handle()
    {
        return $this->roomRepository->getRooms();
    }
}
