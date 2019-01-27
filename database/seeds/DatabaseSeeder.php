<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     * @param Faker $faker
     * @return void
     */
    public function run(Faker $faker)
    {
        foreach (range(1,5) as $i) {
            DB::table('tasks')->insert([
                'name' => $faker->sentence(),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        }
    }
}
