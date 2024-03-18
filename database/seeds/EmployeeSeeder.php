<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\General\Employee;

class EmployeeSeeder extends Seeder
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
          Employee::insert([
              'nip' => $faker->numberBetween(100000,890000),
              'nidn' => $faker->numberBetween(100000,890000),
              'name' => $faker->name,
              'email' => $faker->email,
              'phone_number' => $faker->phoneNumber(),
              'created_at' => $faker->date(now()),
              'updated_at' => $faker->date(now()),
          ]);

        }
    }
}
