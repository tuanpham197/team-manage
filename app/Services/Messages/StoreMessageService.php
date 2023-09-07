<?php

declare(strict_types=1);

namespace App\Services\Messages;

use App\Events\MessageRoomPost;
use App\Models\RoomMember;
use App\Repositories\Messages\MessageInterface;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Exception;
use Log;

class StoreMessageService
{
    private $repository;

    public function __construct(MessageInterface $repositry)
    {
        $this->repository = $repositry;
    }

    public function handle(array $input)
    {
        try {
            DB::beginTransaction();
            $input = array_merge($input, [
                'creator_id' => auth()->user()->id,
                'send_at' => Carbon::now(),
            ]);
            $message = $this->repository->create($input);
            $this->repository->addCountUnSeen($message->room_id);
            $this->repository->updateLastMessageForRoom($message);

            DB::commit();
            //            if ($message) {
            //                broadcast(new MessageRoomPost($message))->toOthers();
            //            }

            return $message;
        } catch (Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());

            return null;
        }
    }

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

            return [];
        }
    }
}
