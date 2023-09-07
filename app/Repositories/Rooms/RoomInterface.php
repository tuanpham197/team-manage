<?php

declare(strict_types=1);

namespace App\Repositories\Rooms;

use App\Enums\RoomTypeEnum;

interface RoomInterface
{
    /**
     * Get user has task in progress
     *
     * @return mixed
     */
    public function getRooms();

    public function getRoomsByType(int $owerId, int $guestId, int $type = RoomTypeEnum::SINGLE);
}
