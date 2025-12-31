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
            ['unitid' => 'RAD', 'unitnama' => 'RADIOLOGI'],
            ['unitid' => 'RM', 'unitnama' => 'REKAM MEDIS'],
            ['unitid' => 'LAB', 'unitnama' => 'LABORATORIUM'],
            ['unitid' => 'JANGMED', 'unitnama' => 'MANAJEMEN JANGMED'],

            // Tambahan dari kamu
            ['unitid' => 'GUD', 'unitnama' => 'GUDANG UMUM'],
            ['unitid' => 'FRONT', 'unitnama' => 'FRONT OFFICE'],
            ['unitid' => 'FAR', 'unitnama' => 'FARMASI'],
            ['unitid' => 'IGD', 'unitnama' => 'INSTALASI GAWAT DARURAT'],
            ['unitid' => 'POLI', 'unitnama' => 'POLIKLINIK'],
            ['unitid' => 'KEP', 'unitnama' => 'KEPERAWATAN'],
        ];

        foreach ($data as &$item) {
            $item['created_at'] = now();
            $item['updated_at'] = now();
        }

        DB::table('m_units')->insertOrIgnore($data);
    }
}
