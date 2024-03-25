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
        $faker = Faker::create('id_EN');

        for($i = 1; $i <= 10; $i++){
 
            // insert data ke table pegawai menggunakan Faker
            User::insert([
              'name' => $faker->name,
              'email' => $faker->email,
              'password' => bcrypt('123456'),
              'role_id' => $faker->numberBetween(1,4),
              'created_at' => $faker->date(now()),
              'updated_at' => $faker->date(now()),
          ]);

        }
    }
}
