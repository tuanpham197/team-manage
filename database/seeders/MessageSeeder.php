<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\MessageTypeEnum;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MessageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('messages')->insert([
            [
                'body' => 'Hi Fan Nhan',
                'room_id' => 1,
                'type' => MessageTypeEnum::TEXT,
                'send_at' => Carbon::now(),
                'creator_id' => 2,
                'seen_at' => null,
            ],
        ]);
    }
}
