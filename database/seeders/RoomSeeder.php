<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\MessageTypeEnum;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('rooms')->insert([
            [
                'custom_name' => '',
                'last_message' => 'Hello',
                'last_message_at' => Carbon::now(),
                'last_message_type' => MessageTypeEnum::TEXT,
                'custom_avatar' => '',
            ],
        ]);
    }
}
