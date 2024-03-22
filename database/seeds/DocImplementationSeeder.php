<?php

use Illuminate\Database\Seeder;
use App\Models\Implementation\DocumentImplementation;

class DocImplementationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $records = [
            ['id' => '1','doc_name' => 'SK Auditor','id_period' => 1,'is_archive' => 0,'created_at' => now(),'updated_at' => now()],
            ['id' => '2','doc_name' => 'Tindak Lanjut AMI Tahun Sebelumnya (validasi auditor)','id_period' => 1,'is_archive' => 0,'created_at' => now(),'updated_at' => now()],
            ['id' => '3','doc_name' => 'Form Monitoring','id_period' => 1,'is_archive' => 0,'created_at' => now(),'updated_at' => now()],
            ['id' => '4','doc_name' => 'Kertas Kerja Auditor','id_period' => 1,'is_archive' => 0,'created_at' => now(),'updated_at' => now()],
            ['id' => '5','doc_name' => 'Daftar Temuan Audit','id_period' => 1,'is_archive' => 0,'created_at' => now(),'updated_at' => now()],
            ['id' => '6','doc_name' => 'Laporan Hasil AMI','id_period' => 1,'is_archive' => 0,'created_at' => now(),'updated_at' => now()],
            ['id' => '7','doc_name' => 'Presensi','id_period' => 1,'is_archive' => 0,'created_at' => now(),'updated_at' => now()],
            ['id' => '8','doc_name' => 'Dokumentasi (Proses AMI, Penyerahan Hasil AMI)','id_period' => 1,'is_archive' => 0,'created_at' => now(),'updated_at' => now()]
       ];
       DocumentImplementation::insert($records);
    }
}
