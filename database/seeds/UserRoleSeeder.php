<?php

use Illuminate\Database\Seeder;
use App\Models\Lpm\UserRole;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $records = [
            ['id' => '1','role_name' => 'LPM','created_at' => now(),'updated_at' => now()],
            ['id' => '2','role_name' => 'Auditor','created_at' => now(),'updated_at' => now()],
            ['id' => '3','role_name' => 'Fakultas','created_at' => now(),'updated_at' => now()],
            ['id' => '4','role_name' => 'Rektorat','created_at' => now(),'updated_at' => now()]
       ];
       UserRole::insert($records);
    }
}
