<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MMasterGudangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'kode_gudang' => 'GUD_RAD',
                'nama_gudang' => 'Gudang Radiologi',
                'unitid' => 'RAD',
                'penanggung_jawab' => 'Budi Santoso',
                'is_active' => true,
            ],
            [
                'kode_gudang' => 'GUD_RM',
                'nama_gudang' => 'Gudang Rekam Medis',
                'unitid' => 'RM',
                'penanggung_jawab' => 'Rina Kurnia',
                'is_active' => true,
            ],
            [
                'kode_gudang' => 'GUD_LAB',
                'nama_gudang' => 'Gudang Laboratorium',
                'unitid' => 'LAB',
                'penanggung_jawab' => 'Agus Rahman',
                'is_active' => true,
            ],
            [
                'kode_gudang' => 'GUD_JM',
                'nama_gudang' => 'Gudang Manajemen Jangmed',
                'unitid' => 'JANGMED',
                'penanggung_jawab' => 'Siti Wahyuni',
                'is_active' => true,
            ],
            [
                'kode_gudang' => 'GUD_FAR',
                'nama_gudang' => 'Gudang Farmasi',
                'unitid' => 'FAR',
                'penanggung_jawab' => 'Dewi Lestari',
                'is_active' => true,
            ],
            [
                'kode_gudang' => 'GUD_IGD',
                'nama_gudang' => 'Gudang IGD',
                'unitid' => 'IGD',
                'penanggung_jawab' => 'Andi Pratama',
                'is_active' => true,
            ],
            [
                'kode_gudang' => 'GUD_POLI',
                'nama_gudang' => 'Gudang Poliklinik',
                'unitid' => 'POLI',
                'penanggung_jawab' => 'Eka Sari',
                'is_active' => true,
            ],
            [
                'kode_gudang' => 'GUD_KEP',
                'nama_gudang' => 'Gudang Keperawatan',
                'unitid' => 'KEP',
                'penanggung_jawab' => 'Nur Aisyah',
                'is_active' => true,
            ],
            [
                'kode_gudang' => 'GUD_UMUM',
                'nama_gudang' => 'Gudang Umum',
                'unitid' => 'GUD',
                'penanggung_jawab' => 'Rahmat Hidayat',
                'is_active' => true,
            ],
            [
                'kode_gudang' => 'GUD_FRONT',
                'nama_gudang' => 'Gudang Front Office',
                'unitid' => 'FRONT',
                'penanggung_jawab' => 'Lina Marlina',
                'is_active' => true,
            ],
        ];

        foreach ($data as &$item) {
            $item['created_at'] = now();
            $item['updated_at'] = now();
        }

        DB::table('m_master_gudangs')->insertOrIgnore($data);
    }
}
