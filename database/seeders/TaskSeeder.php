<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tasks')->insert([
            [
                'title' => 'Task 1',
                'creator_id' => 1,
            ],
            [
                'title' => 'Task 2',
                'creator_id' => 1,
            ],
            [
                'title' => 'Task 3',
                'creator_id' => 1,
            ],
            [
                'title' => 'Task 4',
                'creator_id' => 1,
            ],
        ]);
    }
}
