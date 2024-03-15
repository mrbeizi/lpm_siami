<?php

use Illuminate\Database\Seeder;
use App\Models\General\Faculty;

class FacultySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $records = [
            ['id' => '1','id_periode' => 1,'faculty_name' => 'Bisnis','created_at' => now(), 'updated_at' => now()],
            ['id' => '2','id_periode' => 1,'faculty_name' => 'Komputer','created_at' => now(), 'updated_at' => now()],
            ['id' => '3','id_periode' => 1,'faculty_name' => 'Seni','created_at' => now(), 'updated_at' => now()],
            ['id' => '4','id_periode' => 1,'faculty_name' => 'Teknik','created_at' => now(), 'updated_at' => now()],
            ['id' => '5','id_periode' => 1,'faculty_name' => 'Pendidikan, Bahasa dan Budaya','created_at' => now(), 'updated_at' => now()]
       ];
       Faculty::insert($records);
    }
}
