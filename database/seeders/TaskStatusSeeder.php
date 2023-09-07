<?php

declare(strict_types=1);

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TaskStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('task_statuses')->insert([
            [
                'name' => 'New Request',
                'created_at' => Carbon::now(),
            ],
            [
                'name' => 'In Progress',
                'created_at' => Carbon::now(),
            ],
            [
                'name' => 'Complete',
                'created_at' => Carbon::now(),
            ],
            [
                'name' => 'Ready for Review',
                'created_at' => Carbon::now(),
            ],
        ]);
    }
}
