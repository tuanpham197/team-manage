<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tags')->insert([
            [
                'title' => 'Plan',
                'bg_color' => 'cgray-1',
                'text_color' => 'c-white',
                'is_master' => true,
            ],
            [
                'title' => 'UI',
                'bg_color' => 'cgray-1',
                'text_color' => 'c-white',
                'is_master' => true,
            ],
            [
                'title' => 'Design',
                'bg_color' => 'cgray-1',
                'text_color' => 'c-white',
                'is_master' => true,
            ],
            [
                'title' => 'Backend',
                'bg_color' => 'cgray-1',
                'text_color' => 'c-white',
                'is_master' => true,
            ],
        ]);
    }
}
