<?php

declare(strict_types=1);

namespace App\Services\Rooms;

use App\Repositories\RoomMembers\RoomMemberInterface;
use App\Repositories\Rooms\RoomInterface;
use Illuminate\Support\Facades\DB;
use Exception;
use Log;

class CreateRoomService
{
    private $roomReposity;

    private $roomMemberReposity;

    public function __construct(RoomInterface $roomReposity, RoomMemberInterface $roomMemberReposity)
    {
        $this->roomReposity = $roomReposity;
        $this->roomMemberReposity = $roomMemberReposity;
    }

    public function handle(array $input)
    {
        try {
            DB::beginTransaction();
            // create room
            //        $input = array_merge($input, [])
            $room = $this->roomReposity->create($input);

            // add member to room
            $this->roomMemberReposity->create([
                'room_id' => $room->id,
                'member_id' => $input['owner_id'],
                'count_unseen' => 0,
            ]);

            $this->roomMemberReposity->create([
                'room_id' => $room->id,
                'member_id' => $input['guest_id'],
                'count_unseen' => 0,
            ]);
            DB::commit();

            return $room;
        } catch (Exception $e) {
            Log::error('BUG CUA NHAN ---> ' . $e->getMessage() . ' Line: ' . $e->getTraceAsString());
            DB::rollBack();

            return null;
        }
    }
}
