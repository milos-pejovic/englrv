<?php

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

        // TODO: Add check if environment is DEVELOPMENT
        

        $this->call(UserSeeder::class);
        $this->call(TagSeeder::class);
        $this->call(ExerciseSeeder::class);
    }
}
