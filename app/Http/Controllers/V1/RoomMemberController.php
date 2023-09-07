<?php

declare(strict_types=1);

namespace App\Http\Controllers\V1;

use App\Constants\Constants;
use App\Enums\RoomTypeEnum;
use App\Helpers\ResponseApi;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateRoomMemberRequest;
use App\Repositories\RoomMembers\RoomMemberInterface;
use Illuminate\Http\Request;

class RoomMemberController extends Controller
{
    private $repository;

    public function __construct(RoomMemberInterface $respo)
    {
        $this->repository = $respo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
    public function update(UpdateRoomMemberRequest $request, $id)
    {
        $dataValidated = $request->validated();
        $input = array_merge($dataValidated, [
            'count_unseen' => $dataValidated['count_unseen'] ?? 0,
        ]);
        $result = $this->repository->update($id, $input);
        if (! $result) {
            return ResponseApi::responseFail([
                'code' => 'E0056',
                'params' => [],
            ]);
        }

        return ResponseApi::responseSuccess((bool) $result);
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

    public function getRoom(Request $request)
    {
        $input = $request->only('owner_id', 'guest_id', 'type');
        $roomMember = $this->repository->getRoomMember($input['owner_id'] ?? 0, $input['guest_id'] ?? 0, $input['type'] ?? RoomTypeEnum::SINGLE);
        if (empty($roomMember)) {
            return ResponseApi::responseFail(Constants::MESSAGE_NOT_FOUND);
        }

        return ResponseApi::responseSuccess($roomMember);
    }
}
