<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //        \App\Models\User::factory(1)->create();
        $this->call([
            RoomSeeder::class,
            RoomMemberSeeder::class,
            MessageSeeder::class,
        ]);
    }
}
