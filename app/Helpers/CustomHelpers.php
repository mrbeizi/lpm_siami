<?php

/**
 *
 * Set active css class if the specific URI is current URI
 *
 * @param string $path       A specific URI
 * @param string $class_name Css class name, optional
 * @return string            Css class name if it's current URI,
 *                           otherwise - empty string
 */
    function set_active($route)
    {
        if(Route::is($route))
        {
            return 'active';
        }
    }

    function tanggal_indonesia($tgl, $tampil_hari=false){
        $nama_hari=array("Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jum'at", "Sabtu");
        $nama_bulan = array (
                1 => "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus",
                "September", "Oktober", "November", "Desember");
        $tahun=substr($tgl,0,4);
        $bulan=$nama_bulan[(int)substr($tgl,5,2)];
        $tanggal=substr($tgl,8,2);
        $text="";
        if ($tampil_hari) {
            $urutan_hari=date('w', mktime(0,0,0, substr($tgl,5,2), $tanggal, $tahun));
            $hari=$nama_hari[$urutan_hari];
            $text .= $hari.", ";
        }
            $text .=$tanggal ." ". $bulan ." ". $tahun;
        return $text;
    }

    if(!function_exists('currency_IDR'))
    {
        function currency_IDR($value)
        {
            return "Rp." .number_format($value,0,',','.');
        }
    }

    if(!function_exists('currencyIDRToNumeric'))
    {
        function currencyIDRToNumeric($value)
        {
            return preg_replace('/\D/','', $value);
        }
    }