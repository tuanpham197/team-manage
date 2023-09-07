<?php

declare(strict_types=1);

namespace App\Repositories\RoomMembers;

use App\Enums\RoomTypeEnum;

interface RoomMemberInterface
{
    public function getRoomMember(int $ownerId, int $guestId, int $type = RoomTypeEnum::SINGLE);
}
