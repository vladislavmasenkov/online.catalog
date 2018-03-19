<?php

use Illuminate\Database\Seeder;

class PositionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($count = 0;$count < 30;$count++) {
            DB::table('positions')->insert([
               'name' => str_random(20)
            ]);
        }
    }
}
