<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FoldersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('folders')->insert([
            [
                'name' => 'Работа',
                'slug' => 'rabota',
                'description' => 'Для работы',
                'color' => '#d0a2ff',
                'color_name' => 'красный',
            ],
            [
                'name' => 'Учеба',
                'slug' => 'ucheba',
                'description' => 'Для учебы',
                'color' => '#cc0000',
                'color_name' => 'красный',
            ],
            [
                'name' => 'Личное',
                'slug' => 'lichnoe',
                'description' => 'личное',
                'color' => '#16537e',
                'color_name' => 'красный',
            ],
        ]);
    }
}
