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
        $faker = Faker\Factory::create('Ru_RU');
        for($count = 0;$count < 50000;$count++) {
            $name = explode(' ',$faker->name);
            DB::table('employees')->insert([
                'first_name' => array_shift($name),
                'last_name' => array_shift($name),
                'middle_name' => array_shift($name),
                'position_id' => random_int(1,30),
                'employment_date' => $faker->date(),
                'director_id' => \App\Employee::inRandomOrder()->value('id'),
                'wage' => random_int(700,4000)
            ]);
        }
    }
}
