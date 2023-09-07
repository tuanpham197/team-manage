<?php

declare(strict_types=1);

namespace App\Repositories\Messages;

use App\Models\Message;
use App\Models\Room;
use App\Models\RoomMember;
use App\Repositories\AbstractEloquentRepository;
use Illuminate\Support\Facades\Auth;

class MessageRepository extends AbstractEloquentRepository implements MessageInterface
{
    public function getModel(): string
    {
        return Message::class;
    }

    /**
     * @return void
     */
    public function addCountUnSeen(int $roomId)
    {
        $memberRooms = RoomMember::where('room_id', $roomId)
            ->get();
        foreach ($memberRooms as $member) {
            if ($member->member_id == Auth::user()->id) {
                $member->count_unseen = 0;
            } else {
                $member->count_unseen = $member->count_unseen + 1;
            }
            $member->save();
        }
    }

    /**
     * @return int
     */
    public function updateLastMessageForRoom($message)
    {
        return Room::query()
            ->where('id', $message->room_id)
            ->update([
                'last_message' => $message->body,
                'last_message_at' => $message->send_at,
            ]);
    }
}
