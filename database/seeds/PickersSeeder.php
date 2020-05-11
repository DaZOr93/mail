<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PickersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('pickers')->insert([
            [
                'email' => 'it2.0team3@gmail.com',
                'password' => 'hedbv2580',
                'driver' => 'imap',
                'port' => 993
            ],
        ]);
    }
}
