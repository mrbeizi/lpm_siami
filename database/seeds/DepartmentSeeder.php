<?php

use Illuminate\Database\Seeder;
use App\Models\General\Department;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $records = [
            ['id' => '1','id_periode' => 1,'id_faculty'=> 3,'department_name' => 'Seni Tari','created_at' => now(), 'updated_at' => now()],
            ['id' => '2','id_periode' => 1,'id_faculty'=> 3,'department_name' => 'Seni Musik','created_at' => now(), 'updated_at' => now()],
            ['id' => '3','id_periode' => 1,'id_faculty'=> 1,'department_name' => 'Manajemen','created_at' => now(), 'updated_at' => now()],
            ['id' => '4','id_periode' => 1,'id_faculty'=> 1,'department_name' => 'Akuntansi','created_at' => now(), 'updated_at' => now()],
            ['id' => '5','id_periode' => 1,'id_faculty'=> 2,'department_name' => 'Teknik Informatika','created_at' => now(), 'updated_at' => now()],
            ['id' => '6','id_periode' => 1,'id_faculty'=> 2,'department_name' => 'Sistem Informasi','created_at' => now(), 'updated_at' => now()],
            ['id' => '7','id_periode' => 1,'id_faculty'=> 2,'department_name' => 'Teknik Perangkat Lunak','created_at' => now(), 'updated_at' => now()],
            ['id' => '8','id_periode' => 1,'id_faculty'=> 4,'department_name' => 'Teknik Industri','created_at' => now(), 'updated_at' => now()],
            ['id' => '9','id_periode' => 1,'id_faculty'=> 4,'department_name' => 'Teknik Lingkungan','created_at' => now(), 'updated_at' => now()],
            ['id' => '10','id_periode' => 1,'id_faculty'=> 5,'department_name' => 'Pendidikan Bahasa Mandarin','created_at' => now(), 'updated_at' => now()]
       ];
       Department::insert($records);
    }
}
