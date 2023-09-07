<?php

declare(strict_types=1);

namespace App\Services\Rooms;

use App\Enums\RoomTypeEnum;
use App\Repositories\RoomMembers\RoomMemberInterface;

class GetRoomMemberService
{
    private $repository;

    public function __construct(RoomMemberInterface $repository)
    {
        $this->repository = $repository;
    }

    public function handle(int $ownerId, int $guestId, int $type = RoomTypeEnum::SINGLE)
    {
        // $room = $this->repository->getRoomByType($ownerId, $guestId, $type);

        // return $room;
    }
}
