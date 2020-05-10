<?php

use Illuminate\Database\Seeder;
use App\User;
use Faker\Factory as Faker;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        User::create([
            'username' => $faker->userName,
            'name' => 'llll',
            'email' => 'admin@test.com',
            'password' => \Hash::make('secret'),
            'role' => 'superadmin'
        ]);

        for ($i = 0; $i < 3; $i++) {
            User::create([
                'username' => $faker->userName,
                'name' => $faker->name,
                'email' => $faker->safeEmail,
                'password' => \Hash::make('secret'),
                'role' => 'admin'
            ]);
        }

        for ($i = 0; $i < 10; $i++) {
            User::create([
                'username' => $faker->userName,
                'name' => $faker->name,
                'email' => $faker->safeEmail,
                'password' => \Hash::make('secret'),
                'role' => 'user'
            ]);
        }
    }
}
