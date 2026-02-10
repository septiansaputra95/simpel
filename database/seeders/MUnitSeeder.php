<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MUnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            // ROOT
            // ['unitid' => 'RS', 'unitnama' => 'RSU HERMINA PEKALONGAN', 'parent_id' => NULL, 'limit_nominal' => 0],
            // MANAJEMEN
            // ['unitid' => 'MANKEP', 'unitnama' => 'MANAJER KEPERAWATAN', 'parent_id' => 1, 'limit_nominal' => 0],
            // ['unitid' => 'MANMKT', 'unitnama' => 'MANAJER MARKETING', 'parent_id' => 1, 'limit_nominal' => 0],
            // ['unitid' => 'MANJANGMED', 'unitnama' => 'MANAJER JANGMED', 'parent_id' => 1, 'limit_nominal' => 0],
            // ['unitid' => 'MANYANMED', 'unitnama' => 'MANAJER YANMED', 'parent_id' => 1, 'limit_nominal' => 0],
            // ['unitid' => 'MANJANGUM', 'unitnama' => 'MANAJER JANGUM', 'parent_id' => 1, 'limit_nominal' => 0],
            // ['unitid' => 'MANKEU', 'unitnama' => 'MANAJER KEUANGAN', 'parent_id' => 1, 'limit_nominal' => 0],
            // ['unitid' => 'MANJKN', 'unitnama' => 'MANAJER JKN', 'parent_id' => 1, 'limit_nominal' => 0],
            // ['unitid' => 'MANHRD', 'unitnama' => 'MANAJER HRD', 'parent_id' => 1, 'limit_nominal' => 0],
            // ['unitid' => 'MANMUTU', 'unitnama' => 'MANAJER MUTU', 'parent_id' => 1, 'limit_nominal' => 0],

            // KEPERAWATAN
            ['unitid' => 'OK', 'unitnama' => 'KAMAR OPERASI', 'parent_id' => 2, 'limit_nominal' => 200000],
            ['unitid' => 'VK', 'unitnama' => 'KAMAR BERSALIN', 'parent_id' => 2, 'limit_nominal' => 200000],
            ['unitid' => 'NSLT3', 'unitnama' => 'RUANG PERAWATAN LT 3', 'parent_id' => 2, 'limit_nominal' => 200000],
            
            // MARKETING
            ['unitid' => 'FRONT', 'unitnama' => 'FRONT OFFICE', 'parent_id' => 3, 'limit_nominal' => 200000],
            ['unitid' => 'MKT', 'unitnama' => 'MARKETING', 'parent_id' => 3, 'limit_nominal' => 200000],

            // JANGMED
            ['unitid' => 'RAD', 'unitnama' => 'RADIOLOGI', 'parent_id' => 4, 'limit_nominal' => 200000],
            ['unitid' => 'RM', 'unitnama' => 'REKAM MEDIS', 'parent_id' => 4, 'limit_nominal' => 200000],
            ['unitid' => 'LAB', 'unitnama' => 'LABORATORIUM', 'parent_id' => 4, 'limit_nominal' => 200000],
            ['unitid' => 'FAR', 'unitnama' => 'FARMASI', 'parent_id' => 4, 'limit_nominal' => 200000],
            ['unitid' => 'CSSU', 'unitnama' => 'CENTRAL STERYL SUPPLY UNIT', 'parent_id' => 4, 'limit_nominal' => 200000],

            // YANMED
            ['unitid' => 'IGD', 'unitnama' => 'INSTALASI GAWAT DARURAT', 'parent_id' => 5, 'limit_nominal' => 200000],
            ['unitid' => 'FIS', 'unitnama' => 'FISIOTERAPI - KTK', 'parent_id' => 5, 'limit_nominal' => 200000],
            
            // JANGUM
            ['unitid' => 'GIZ', 'unitnama' => 'GIZI - DAPUR', 'parent_id' => 6, 'limit_nominal' => 200000],
            ['unitid' => 'GUD', 'unitnama' => 'GUDANG UMUM', 'parent_id' => 6, 'limit_nominal' => 200000],
            ['unitid' => 'IPSRS', 'unitnama' => 'IPSRS TEKNISI', 'parent_id' => 6, 'limit_nominal' => 200000],
            ['unitid' => 'ATM', 'unitnama' => 'TEKNISI ATEM', 'parent_id' => 6, 'limit_nominal' => 200000],
            ['unitid' => 'YANUM', 'unitnama' => 'PELAYANAN UMUM', 'parent_id' => 6, 'limit_nominal' => 200000],
            
            // KEUANGAN
            ['unitid' => 'KEU', 'unitnama' => 'KEUANGAN OFFICE', 'parent_id' => 7, 'limit_nominal' => 200000],
            ['unitid' => 'KSR', 'unitnama' => 'KASIR', 'parent_id' => 7, 'limit_nominal' => 200000],

            // JKN
            ['unitid' => 'CSMX', 'unitnama' => 'CASEMIX', 'parent_id' => 8, 'limit_nominal' => 200000],

            //HRD
            ['unitid' => 'HRD', 'unitnama' => 'HRD KESRA - REKRUTMENT', 'parent_id' => 9, 'limit_nominal' => 200000],

            // MUTU
            ['unitid' => 'PPI', 'unitnama' => 'PPI', 'parent_id' => 10, 'limit_nominal' => 200000],
            ['unitid' => 'MUTU', 'unitnama' => 'MUTU', 'parent_id' => 10, 'limit_nominal' => 200000],

            
        ];

        foreach ($data as &$item) {
            $item['created_at'] = now();
            $item['updated_at'] = now();
        }

        DB::table('m_units')->insertOrIgnore($data);
    }
}
