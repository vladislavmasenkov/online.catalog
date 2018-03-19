<?php

use Illuminate\Database\Seeder;

class EmployeesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($count = 0;$count < 50000;$count++) {
            DB::table('employees')->insert([
                'first_name' => str_random(16),
                'last_name' => str_random(16),
                'middle_name' => str_random(16),
                'position' => random_int(1,30),
                'employment_date' => date('d.m.Y')
            ]);
        }
    }
}
