<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoomMemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('room_members')->insert([
            [
                'room_id' => 1,
                'member_id' => 1,
                'count_unseen' => 0,
            ],
            [
                'room_id' => 1,
                'member_id' => 2,
                'count_unseen' => 1,
            ],
        ]);
    }
}
