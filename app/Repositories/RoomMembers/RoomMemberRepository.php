<?php

declare(strict_types=1);

namespace App\Repositories\RoomMembers;

use App\Enums\RoomTypeEnum;
use App\Models\RoomMember;
use App\Repositories\AbstractEloquentRepository;

class RoomMemberRepository extends AbstractEloquentRepository implements RoomMemberInterface
{
    public function getModel()
    {
        // TODO: Implement getModel() method.
        return RoomMember::class;
    }

    public function getRoomMember(int $ownerId, int $guestId, int $type = RoomTypeEnum::SINGLE)
    {
        $guestRoomIds = RoomMember::where('member_id', $guestId)
            ->get()
            ->pluck('room_id')
            ->toArray();

        $method = $type == RoomTypeEnum::SINGLE ? 'first' : 'get';

        return RoomMember::where('member_id', $ownerId)
            ->whereIn('room_id', $guestRoomIds)
            ->whereHas('room', function ($query) use ($type) {
                $query->where('type', $type);
            })
            ->$method();
    }
}
