<?php

declare(strict_types=1);

namespace App\Http\Controllers\V1;

use App\Constants\Constants;
use App\Enums\RoomTypeEnum;
use App\Events\MessagePosted;
use App\Helpers\ResponseApi;
use App\Http\Controllers\Controller;
use App\Http\Requests\RoomRequest;
use App\Repositories\Rooms\RoomInterface;
use App\Services\Rooms\CreateRoomService;
use App\Services\Rooms\RoomService;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    private $roomRepository;

    public function __construct(RoomInterface $repository)
    {
        $this->roomRepository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = resolve(RoomService::class)->handle();

        broadcast(new MessagePosted(123))->toOthers();
        // MessagePosted::dispatch('xx');
        return ResponseApi::responseSuccess($data);
    }

    /**
     * Display a latest listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function latest()
    {
        $data = $this->roomRepository->getLatestRooms();

        return ResponseApi::responseSuccess($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RoomRequest $request)
    {
        $result = resolve(CreateRoomService::class)->handle($request->validated());
        if (! $result) {
            return ResponseApi::responseFail(Constants::MESSAGE_FAIL);
        }

        return ResponseApi::responseSuccess($result);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = $this->roomRepository->getRoomDetail($id);

        return ResponseApi::responseSuccess($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function getRoomsByType(Request $request)
    {
        $input = $request->only('owner_id', 'guest_id', 'type');
        $room = $this->roomRepository->getRoomsByType($input['owner_id'] ?? 0, $input['guest_id'] ?? 0, $input['type'] ?? RoomTypeEnum::SINGLE);
        if (empty($room)) {
            return ResponseApi::responseFail(Constants::MESSAGE_NOT_FOUND);
        }

        return ResponseApi::responseSuccess($room);
    }
}
