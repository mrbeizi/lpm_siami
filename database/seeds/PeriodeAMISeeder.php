<?php

use Illuminate\Database\Seeder;
use App\Models\General\Period;

class PeriodeAMISeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $records = [
            ['id' => '1','title' => 'AMI 2024','start_date' => '2024-10-11','end_date' => '2024-10-24','is_active' => 1,'created_at' => now(), 'updated_at' => now()],
       ];
       Period::insert($records);
    }
}
