<?php

declare(strict_types=1);

namespace App\Repositories\Rooms;

use App\Enums\RoomTypeEnum;
use App\Models\Room;
use App\Models\Message;
use App\Repositories\AbstractEloquentRepository;
use App\Repositories\RoomMembers\RoomMemberInterface;
use Illuminate\Database\Query\JoinClause;

class RoomRepository extends AbstractEloquentRepository implements RoomInterface
{
    private $roomMemberRepo;

    public function __construct(RoomMemberInterface $repo)
    {
        $this->roomMemberRepo = $repo;
    }

    /**
     * Get model
     */
    public function getModel(): string
    {
        // TODO: Implement getModel() method.
        return Room::class;
    }

    public function getRooms()
    {
        $user_id = auth()->user()->id;

        return Room::with('members.user')
            ->whereHas('members', function ($query) use ($user_id) {
                $query->where('member_id', $user_id);
            })
            ->orderBy('last_message_at', 'desc')
            ->get();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|object|null
     */
    public function getRoomDetail($id)
    {
        return Room::with(['members.user', 'messages'])
            ->where('id', $id)
            ->first();
    }

    public function getLatestRooms()
    {
        $user_id = auth()->user()->id;

        $roomIds = Room::select('id')
            ->whereHas('members', function ($query) use ($user_id) {
                $query->where('member_id', $user_id);
            })
            ->get()
            ->pluck('id')
            ->toArray();

        $data = Message::select(
            'users.id',
            'users.name',
            'users.email',
            'users.avatar',
        )
            ->join('room_members as cm1', function (JoinClause $join) use ($roomIds) {
                $join->on('messages.room_id', '=', 'cm1.room_id')
                    ->whereIn('cm1.room_id', $roomIds)
                    ->on('cm1.member_id', '=', 'messages.creator_id');
            })
            ->rightJoin('users', 'messages.creator_id', '=', 'users.id')
            ->where('users.id', '!=', $user_id)
            ->orderBy('send_at', 'desc')
            ->get();

        return $data->unique();
    }

    public function getRoomsByType(int $owerId, int $guestId, int $type = RoomTypeEnum::SINGLE)
    {
        $roomMember = $this->roomMemberRepo->getRoomMember($owerId, $guestId, $type);
        if (! empty($roomMember) && ! is_array($roomMember)) {
            $roomId = $roomMember->room_id;

            return $this->getRoomDetail($roomId);
        }

        return (object) [];
    }
}
